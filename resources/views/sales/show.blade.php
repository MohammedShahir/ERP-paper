@extends('layouts.app')
@section('title')
    {{ __('messages.sale.show_title', ['id' => $sale->id]) }}
@endsection
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">{{ __('messages.sale.show_title', ['id' => $sale->id]) }}</h1>
        <a href="{{ route('sales.index') }}" class="px-3 py-2 rounded border">{{ __('messages.general.back') }}</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="rounded border border-[#e3e3e0] bg-white p-4">
            <div class="text-sm text-[#706f6c]">{{ __('messages.general.date') }}</div>
            <div class="font-medium">{{ $sale->date->format('Y-m-d') }}</div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4">
            <div class="text-sm text-[#706f6c]">{{ __('messages.general.customers') }}</div>
            <div class="font-medium">{{ $sale->customer->name ?? __('messages.general.walk_in') }}</div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4">
            <div class="text-sm text-[#706f6c]">{{ __('messages.general.total') }}</div>
            <div class="font-medium">${{ number_format($sale->total, 2) }}</div>
        </div>
    </div>

    <div class="mb-4 flex items-center gap-2">
        <a href="{{ route('vouchers.create', ['type' => 'collection', 'amount' => $sale->total, 'reference_type' => 'sale', 'reference_id' => $sale->id, 'cashier_id' => null]) }}"
            class="px-3 py-2 rounded border hover:bg-[#fff2f2]">@lang('messages.voucher.new_collection')</a>
    </div>

    <div class="rounded border border-[#e3e3e0] bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">{{ __('messages.general.product') }}</th>
                    <th class="p-3">{{ __('messages.general.qty') }}</th>
                    <th class="p-3">{{ __('messages.general.unit_price') }}</th>
                    <th class="p-3">{{ __('messages.general.line_total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $it)
                    <tr class="border-t">
                        <td class="p-3">{{ $it->product->name }}</td>
                        <td class="p-3">{{ $it->quantity }}</td>
                        <td class="p-3">${{ number_format($it->unit_price, 2) }}</td>
                        <td class="p-3">${{ number_format($it->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
