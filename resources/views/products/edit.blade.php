@extends('layouts.app')
@section('title', 'Edit Product')
@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit Product</h1>
    <form action="{{ route('products.update', $product) }}" method="POST"
        class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm mb-1">Name</label>
            <input name="name" value="{{ old('name', $product->name) }}" class="w-full rounded border border-[#e3e3e0] p-2"
                required />
        </div>
        <div>
            <label class="block text-sm mb-1">SKU</label>
            <input name="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded border border-[#e3e3e0] p-2"
                required />
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm mb-1">Description</label>
            <textarea name="description" class="w-full rounded border border-[#e3e3e0] p-2" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label class="block text-sm mb-1">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                class="w-full rounded border border-[#e3e3e0] p-2" required />
        </div>
        <div>
            <label class="block text-sm mb-1">Cost Price</label>
            <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}"
                class="w-full rounded border border-[#e3e3e0] p-2" />
        </div>
        <div>
            <label class="block text-sm mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                class="w-full rounded border border-[#e3e3e0] p-2" required />
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <a href="{{ route('products.index') }}" class="px-3 py-2 rounded border">Cancel</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">Update</button>
        </div>
    </form>
@endsection
