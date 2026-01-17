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
        $query = Transaction::with(['items.product']);
        
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

    // Method untuk menampilkan form transaksi baru
    public function create()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('transactions.create', compact('products'));
    }

    // Method untuk menyimpan transaksi
    public function store(Request $request)
    {
        // Validasi lebih fleksibel
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.selected' => 'nullable',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $transaction = Transaction::create([
                    'total_price' => 0,
                ]);

                $total = 0;
                $hasItems = false;

                foreach ($request->items as $item) {
                    // cek apakah checkbox dicentang
                    if (!isset($item['selected']) || !$item['selected']) {
                        continue; // skip produk yang tidak dipilih
                    }

                    $product = Product::findOrFail($item['product_id']);

                    // cek stok
                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception('Stok ' . $product->name . ' tidak cukup. Tersedia: ' . $product->stock_quantity);
                    }

                    $subtotal = $product->price * $item['quantity'];

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);

                    $product->decrement('stock_quantity', $item['quantity']);

                    $total += $subtotal;
                    $hasItems = true;
                }

                // Cek apakah ada item yang dipilih
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