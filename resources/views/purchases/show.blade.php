@extends('layouts.app')
@section('title', 'Purchase #' . $purchase->id)
@section('content')
    <div class="mb-4">
        <a href="{{ route('purchases.index') }}" class="underline text-[#f53003]">Back to purchases</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-5xl">
        <div>
            <div class="text-xs text-[#706f6c]">Date</div>
            <div>{{ $purchase->date->toDateString() }}</div>
        </div>
        <div>
            <div class="text-xs text-[#706f6c]">Supplier</div>
            <div>{{ $purchase->supplier?->name ?? '-' }}</div>
        </div>
        <div>
            <div class="text-xs text-[#706f6c]">Branch</div>
            <div>{{ $purchase->branch?->name ?? '-' }}</div>
        </div>
    </div>

    <div class="rounded border bg-white overflow-hidden mt-4 max-w-5xl">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-2">Product</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Unit Cost</th>
                    <th class="p-2">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase->items as $it)
                    <tr class="border-t">
                        <td class="p-2">{{ $it->product->name }}</td>
                        <td class="p-2">{{ $it->quantity }}</td>
                        <td class="p-2">${{ number_format($it->unit_cost, 2) }}</td>
                        <td class="p-2">${{ number_format($it->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="max-w-5xl mt-4 flex justify-end gap-6 text-sm">
        <div>Subtotal: ${{ number_format($purchase->subtotal, 2) }}</div>
        <div>Tax: ${{ number_format($purchase->tax, 2) }}</div>
        <div class="font-semibold">Total: ${{ number_format($purchase->total, 2) }}</div>
    </div>
@endsection
