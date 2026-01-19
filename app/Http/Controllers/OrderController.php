<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar order dengan filter tanggal
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.product']);
        
        // Filter berdasarkan tanggal mulai
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        // Filter berdasarkan tanggal akhir
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Urutkan dari yang terbaru
        $orders = $query->latest()->get();
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan form untuk membuat order baru
     */
    public function create(Request $request)
    {
        $query = Product::with('category');
        
        // Pencarian produk berdasarkan nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter produk berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->get();
        
        return view('orders.create', compact('products'));
    }

    /**
     * Menyimpan order baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.cost_per_unit' => 'required|numeric|min:0',
            'items.*.selected' => 'nullable',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Buat order utama dengan status pending
                $order = Order::create([
                    'supplier_name' => $request->supplier_name,
                    'total_cost' => 0,
                    'notes' => $request->notes,
                    'status' => 'pending',
                ]);

                $total = 0;
                $hasItems = false;

                // Loop setiap item yang dikirim dari form
                foreach ($request->items as $item) {
                    // Lewati produk yang tidak dicentang
                    if (empty($item['selected'])) {
                        continue;
                    }

                    $product = Product::find($item['product_id']);
                    
                    if (!$product) {
                        throw new \Exception("Produk dengan ID {$item['product_id']} tidak ditemukan");
                    }

                    $qty = (float) $item['quantity'];
                    $cost = (float) $item['cost_per_unit'];

                    // Validasi jumlah harus bulat jika satuan bukan desimal
                    if (!$this->isDecimalUnit($product->unit) && floor($qty) != $qty) {
                        throw new \Exception(
                            "Jumlah {$product->name} harus bilangan bulat (satuan: {$product->unit})"
                        );
                    }

                    // Validasi quantity tidak boleh 0 atau negatif
                    if ($qty <= 0) {
                        throw new \Exception("Jumlah {$product->name} harus lebih dari 0");
                    }

                    // Validasi cost tidak boleh negatif
                    if ($cost < 0) {
                        throw new \Exception("Harga {$product->name} tidak boleh negatif");
                    }

                    $subtotal = $cost * $qty;

                    // Simpan detail order
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'cost_per_unit' => $cost,
                        'subtotal' => $subtotal,
                    ]);

                    // TIDAK menambah stok di sini, tunggu konfirmasi diterima
                    $total += $subtotal;
                    $hasItems = true;
                }

                // Pastikan minimal ada satu produk yang dipilih
                if (!$hasItems) {
                    throw new \Exception('Pilih minimal 1 produk untuk order');
                }

                // Update total biaya order
                $order->update(['total_cost' => $total]);
            });

            return redirect()->route('orders.index')
                ->with('success', 'Order berhasil dibuat. Silakan konfirmasi saat barang diterima untuk menambah stok.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Menampilkan detail order
     */
    public function show(Order $order)
    {
        $order->load(['items.product']);
        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan form untuk edit order
     */
    public function edit(Order $order)
    {
        // Hanya order dengan status pending yang bisa diedit
        if ($order->status === 'received') {
            return redirect()->route('orders.index')
                ->with('error', 'Order yang sudah diterima tidak dapat diedit');
        }
        
        $order->load(['items.product']);
        
        return view('orders.edit', compact('order'));
    }

    /**
     * Mengupdate order yang masih pending ATAU konfirmasi diterima
     */
    public function update(Request $request, Order $order)
    {
        // Cek apakah ini request konfirmasi diterima
        if ($request->has('_confirm_received')) {
            return $this->confirmReceived($order);
        }

        // Hanya order dengan status pending yang bisa diupdate
        if ($order->status === 'received') {
            return redirect()->route('orders.index')
                ->with('error', 'Order yang sudah diterima tidak dapat diubah');
        }
        
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'nullable|exists:order_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.cost_per_unit' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                // Update informasi order
                $order->update([
                    'supplier_name' => $request->supplier_name,
                    'notes' => $request->notes,
                ]);

                $total = 0;
                $hasItems = false;

                // Loop setiap item untuk update
                foreach ($request->items as $item) {
                    $product = Product::find($item['product_id']);
                    
                    if (!$product) {
                        throw new \Exception("Produk dengan ID {$item['product_id']} tidak ditemukan");
                    }

                    $newQty = (float) $item['quantity'];
                    $cost = (float) $item['cost_per_unit'];

                    // Validasi jumlah harus bulat jika satuan bukan desimal
                    if (!$this->isDecimalUnit($product->unit) && floor($newQty) != $newQty) {
                        throw new \Exception(
                            "Jumlah {$product->name} harus bilangan bulat (satuan: {$product->unit})"
                        );
                    }

                    // Validasi quantity tidak boleh 0 atau negatif
                    if ($newQty <= 0) {
                        throw new \Exception("Jumlah {$product->name} harus lebih dari 0");
                    }

                    // Validasi cost tidak boleh negatif
                    if ($cost < 0) {
                        throw new \Exception("Harga {$product->name} tidak boleh negatif");
                    }

                    // Cari order item yang sudah ada
                    if (!empty($item['id'])) {
                        $orderItem = OrderItem::find($item['id']);
                        
                        if (!$orderItem || $orderItem->order_id != $order->id) {
                            throw new \Exception("Order item tidak valid");
                        }
                        
                        $subtotal = $cost * $newQty;
                        
                        // Update order item (TIDAK update stok karena masih pending)
                        $orderItem->update([
                            'quantity' => $newQty,
                            'cost_per_unit' => $cost,
                            'subtotal' => $subtotal,
                        ]);
                        
                        $total += $subtotal;
                        $hasItems = true;
                    }
                }

                // Pastikan ada minimal 1 item
                if (!$hasItems) {
                    throw new \Exception('Order harus memiliki minimal 1 item');
                }

                // Update total biaya order
                $order->update(['total_cost' => $total]);
            });

            return redirect()->route('orders.index')
                ->with('success', 'Order berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Method private untuk konfirmasi order diterima
     * Improved with race condition prevention and better error handling
     */
    private function confirmReceived(Order $order)
    {
        // First check - before transaction
        if ($order->status === 'received') {
            return redirect()->route('orders.index')
                ->with('error', 'Order ini sudah dikonfirmasi sebelumnya');
        }

        try {
            DB::transaction(function () use ($order) {
                // Reload order with lock to prevent race conditions
                $order = Order::lockForUpdate()->find($order->id);
                
                if (!$order) {
                    throw new \Exception('Order tidak ditemukan');
                }
                
                // Double-check status after lock
                if ($order->status === 'received') {
                    throw new \Exception('Order sudah dikonfirmasi oleh pengguna lain');
                }
                
                // Load items
                $order->load('items.product');
                
                // Validate that order has items
                if ($order->items->isEmpty()) {
                    throw new \Exception('Order tidak memiliki item untuk dikonfirmasi');
                }
                
                // Process each item and update stock
                foreach ($order->items as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    
                    if (!$product) {
                        throw new \Exception("Produk tidak ditemukan");
                    }
                    
                    // Validate quantity is positive
                    if ($item->quantity <= 0) {
                        throw new \Exception("Jumlah untuk produk '{$product->name}' tidak valid");
                    }
                    
                    // Update stock
                    $product->increment('stock_quantity', $item->quantity);
                }

                // Update status to received
                $order->update(['status' => 'received']);
            });

            return redirect()->route('orders.index')
                ->with('success', 'Order dikonfirmasi diterima dan stok produk telah ditambahkan');

        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Helper method untuk mengecek apakah satuan menggunakan desimal
     */
    private function isDecimalUnit($unit)
    {
        return in_array(strtolower($unit), ['kg', 'liter', 'l', 'gram', 'ml']);
    }
}