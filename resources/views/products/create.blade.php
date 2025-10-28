@extends('layouts.app')
@section('title', __('messages.product.add'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">{{ __('messages.product.add') }}</h1>
    <form action="{{ route('products.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
        @csrf
        <div>
            <label class="block text-sm mb-1">{{ __('messages.product.name') }}</label>
            <input name="name" class="w-full rounded border border-[#e3e3e0] p-2" required />
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.product.sku') }}</label>
            <input name="sku" class="w-full rounded border border-[#e3e3e0] p-2" required />
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm mb-1">{{ __('messages.product.description') }}</label>
            <textarea name="description" class="w-full rounded border border-[#e3e3e0] p-2" rows="3"></textarea>
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.product.price') }}</label>
            <input type="number" step="0.01" name="price" class="w-full rounded border border-[#e3e3e0] p-2"
                required />
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.product.cost') }}</label>
            <input type="number" step="0.01" name="cost_price" class="w-full rounded border border-[#e3e3e0] p-2" />
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.product.stock') }}</label>
            <input type="number" name="stock" class="w-full rounded border border-[#e3e3e0] p-2" required />
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <a href="{{ route('products.index') }}" class="px-3 py-2 rounded border">{{ __('messages.actions.cancel') }}</a>
            <button
                class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">{{ __('messages.actions.save') }}</button>
        </div>
    </form>
@endsection
