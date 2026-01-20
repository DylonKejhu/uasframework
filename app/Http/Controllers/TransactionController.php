<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Method untuk menampilkan daftar transaksi dengan filter tanggal
    public function index(Request $request)
    {
        $query = Transaction::with(['items.product', 'user']);
        
        // Filter berdasarkan tanggal mulai
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        // Filter berdasarkan tanggal akhir
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $transactions = $query->latest()->get();
        
        return view('transactions.index', compact('transactions'));
    }

    // Method untuk menampilkan form transaksi baru dengan filter
    public function create(Request $request)
    {
        $query = Product::with('category')->where('stock_quantity', '>', 0);
        
        // Search produk berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter berdasarkan kategori
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->get();
        
        return view('transactions.create', compact('products'));
    }

    // Method untuk menyimpan transaksi
    public function store(Request $request)
    {
        // Validation allowing decimals
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.selected' => 'nullable',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $transaction = Transaction::create([
                    'user_id' => auth()->id(), // Auto simpan kasir yang login
                    'total_price' => 0,
                ]);

                $total = 0;
                $hasItems = false;

                foreach ($request->items as $item) {
                    // Skip unchecked items
                    if (empty($item['selected'])) {
                        continue;
                    }

                    $product = Product::findOrFail($item['product_id']);
                    $qty = (float) $item['quantity'];

                    // Enforce integer quantity for non-decimal units
                    if (!in_array(strtolower($product->unit), ['kg', 'liter', 'l']) && floor($qty) != $qty) {
                        throw new \Exception(
                            "Jumlah {$product->name} harus bilangan bulat (satuan: {$product->unit})"
                        );
                    }

                    // Stock check (decimal-safe)
                    if ($product->stock_quantity < $qty) {
                        throw new \Exception(
                            "Stok {$product->name} tidak cukup. Tersedia: {$product->stock_quantity} {$product->unit}"
                        );
                    }

                    $subtotal = $product->price * $qty;

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id'     => $product->id,
                        'quantity'       => $qty,
                        'price'          => $product->price,
                        'subtotal'       => $subtotal,
                    ]);

                    // Decimal-safe stock decrement
                    $product->decrement('stock_quantity', $qty);

                    $total += $subtotal;
                    $hasItems = true;
                }

                if (!$hasItems) {
                    throw new \Exception('Pilih minimal 1 produk untuk checkout');
                }

                $transaction->update([
                    'total_price' => $total,
                ]);
            });

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dibuat');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}