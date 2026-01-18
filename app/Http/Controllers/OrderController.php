<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Menampilkan daftar order dengan filter tanggal
    public function index(Request $request)
    {
        // Ambil order beserta item dan produk terkait
        $query = Order::with(['items.product']);
        
        // Filter berdasarkan tanggal mulai
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        // Filter berdasarkan tanggal akhir
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Urutkan dari yang terbaru
        $orders = $query->latest()->get();
        
        return view('orders.index', compact('orders'));
    }

    // Menampilkan form untuk membuat order baru
    public function create(Request $request)
    {
        // Ambil produk beserta kategorinya
        $query = Product::with('category');
        
        // Pencarian produk berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter produk berdasarkan kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->get();
        
        return view('orders.create', compact('products'));
    }

    // Menyimpan order baru ke database
    public function store(Request $request)
    {
        // Validasi input
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
            // Gunakan transaction agar data konsisten
            DB::transaction(function () use ($request) {

                // Buat order utama terlebih dahulu
                $order = Order::create([
                    'supplier_name' => $request->supplier_name,
                    'total_cost' => 0, // Akan dihitung ulang
                    'notes' => $request->notes,
                ]);

                $total = 0;
                $hasItems = false;

                // Loop setiap item yang dikirim dari form
                foreach ($request->items as $item) {

                    // Lewati produk yang tidak dicentang
                    if (empty($item['selected'])) {
                        continue;
                    }

                    // Ambil data produk
                    $product = Product::findOrFail($item['product_id']);
                    $qty = (float) $item['quantity'];
                    $cost = (float) $item['cost_per_unit'];

                    // Validasi jumlah harus bulat jika satuan bukan desimal
                    if (!in_array(strtolower($product->unit), ['kg', 'liter', 'l']) && floor($qty) != $qty) {
                        throw new \Exception(
                            "Jumlah {$product->name} harus bilangan bulat (satuan: {$product->unit})"
                        );
                    }

                    // Hitung subtotal item
                    $subtotal = $cost * $qty;

                    // Simpan detail order
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'cost_per_unit' => $cost,
                        'subtotal' => $subtotal,
                    ]);

                    // Tambahkan stok produk sesuai jumlah order
                    $product->increment('stock_quantity', $qty);

                    // Akumulasi total harga order
                    $total += $subtotal;
                    $hasItems = true;
                }

                // Pastikan minimal ada satu produk yang dipilih
                if (!$hasItems) {
                    throw new \Exception('Pilih minimal 1 produk untuk order');
                }

                // Update total biaya order
                $order->update([
                    'total_cost' => $total,
                ]);
            });

            return redirect()->route('orders.index')
                ->with('success', 'Order berhasil dibuat dan stok produk ditambahkan');

        } catch (\Exception $e) {
            // Kembalikan ke form jika terjadi error
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}
