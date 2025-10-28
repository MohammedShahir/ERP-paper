<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $branchId = session('branch_id');
        $branchStocks = [];
        if ($branchId) {
            $ids = $products->pluck('id');
            $branchStocks = \App\Models\Inventory::where('branch_id', $branchId)
                ->whereIn('product_id', $ids)
                ->pluck('stock', 'product_id')
                ->toArray();
        }
        return view('products.index', [
            'products' => $products,
            'branchStocks' => $branchStocks,
            'branchId' => $branchId,
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
        ]);

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
        ]);

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
