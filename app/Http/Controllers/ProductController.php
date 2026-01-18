<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Tampilkan semua produk dengan search & filter
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return view('products.index', [
            'products' => $query->get(),
            'categories' => Category::all(),
        ]);
    }

    // Form tambah produk
    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
        ]);
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'price'           => 'required|numeric|min:0',
            'unit'            => 'required|string|max:50',
            'stock_quantity'  => 'required|numeric|min:0',
        ]);

        // Enforce integer stock for non-decimal units
        $unit = strtolower($request->unit);
        $stock = (float) $request->stock_quantity;

        if (!in_array($unit, ['kg', 'liter', 'l']) && floor($stock) != $stock) {
            return back()
                ->withInput()
                ->withErrors(['stock_quantity' => "Stok untuk satuan '{$request->unit}' harus bilangan bulat"]);
        }

        Product::create([
            'name'           => $validated['name'],
            'slug'           => Str::slug($validated['name']),
            'category_id'    => $validated['category_id'],
            'price'          => $validated['price'],
            'unit'           => $validated['unit'],
            'stock_quantity' => $stock,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // Form edit produk
    public function edit(string $id)
    {
        return view('products.edit', [
            'product'    => Product::findOrFail($id),
            'categories' => Category::all(),
        ]);
    }

    // Update produk
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'price'           => 'required|numeric|min:0',
            'unit'            => 'required|string|max:50',
            'stock_quantity'  => 'required|numeric|min:0',
        ]);

        // Enforce integer stock for non-decimal units
        $unit = strtolower($request->unit);
        $stock = (float) $request->stock_quantity;

        if (!in_array($unit, ['kg', 'liter', 'l']) && floor($stock) != $stock) {
            return back()
                ->withInput()
                ->withErrors(['stock_quantity' => "Stok untuk satuan '{$request->unit}' harus bilangan bulat"]);
        }

        $product = Product::findOrFail($id);

        $product->update([
            'name'           => $validated['name'],
            'slug'           => Str::slug($validated['name']),
            'category_id'    => $validated['category_id'],
            'price'          => $validated['price'],
            'unit'           => $validated['unit'],
            'stock_quantity' => $stock,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diupdate');
    }

    // Hapus produk
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}