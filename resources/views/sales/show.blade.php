@extends('layouts.app')
@section('title', 'Sale #' . $sale->id)
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Sale #{{ $sale->id }}</h1>
        <a href="{{ route('sales.index') }}" class="px-3 py-2 rounded border">Back</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="rounded border border-[#e3e3e0] bg-white p-4">
            <div class="text-sm text-[#706f6c]">Date</div>
            <div class="font-medium">{{ $sale->date->format('Y-m-d') }}</div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4">
            <div class="text-sm text-[#706f6c]">Customer</div>
            <div class="font-medium">{{ $sale->customer->name ?? 'Walk-in' }}</div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4">
            <div class="text-sm text-[#706f6c]">Total</div>
            <div class="font-medium">${{ number_format($sale->total, 2) }}</div>
        </div>
    </div>

    <div class="rounded border border-[#e3e3e0] bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">Product</th>
                    <th class="p-3">Qty</th>
                    <th class="p-3">Unit Price</th>
                    <th class="p-3">Line Total</th>
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
