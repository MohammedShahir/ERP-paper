@extends('layouts.app')
@section('title', __('messages.product.title'))
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">{{ __('messages.product.title') }}</h1>
        <a href="{{ route('products.create') }}"
            class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">{{ __('messages.actions.add_product') }}</a>
    </div>

    <div class="rounded border border-[#e3e3e0] bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">{{ __('messages.product.name') }}</th>
                    <th class="p-3">{{ __('messages.product.sku') }}</th>
                    <th class="p-3">{{ __('messages.product.price') }}</th>
                    <th class="p-3">{{ __('messages.product.cost') }}</th>
                    <th class="p-3">{{ __('messages.product.stock') }}</th>
                    <th class="p-3 w-40"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $p)
                    <tr class="border-t">
                        <td class="p-3">{{ $p->name }}</td>
                        <td class="p-3">{{ $p->sku }}</td>
                        <td class="p-3">${{ number_format($p->price, 2) }}</td>
                        <td class="p-3">${{ number_format($p->cost_price, 2) }}</td>
                        <td class="p-3">
                            @if (!empty($branchId))
                                {{ $branchStocks[$p->id] ?? 0 }}
                            @else
                                {{ $p->stock }}
                            @endif
                        </td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('products.edit', $p) }}"
                                class="text-[#f53003] underline">{{ __('messages.actions.edit') }}</a>
                            <form action="{{ route('products.destroy', $p) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-[#f53003] underline"
                                    onclick="return confirm('{{ __('messages.actions.confirm_delete') }}')">{{ __('messages.actions.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
@endsection
