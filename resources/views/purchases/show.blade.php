@extends('layouts.app')
@section('title')
    {{ __('messages.purchase.show_title', ['id' => $purchase->id]) }}
@endsection
@section('content')
    <div class="mb-4">
        <a href="{{ route('purchases.index') }}" class="underline text-[#f53003]">{{ __('messages.purchase.back_to') }}</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-5xl">
        <div>
            <div class="text-xs text-[#706f6c]">{{ __('messages.general.date') }}</div>
            <div>{{ $purchase->date->toDateString() }}</div>
        </div>
        <div>
            <div class="text-xs text-[#706f6c]">{{ __('messages.general.supplier') }}</div>
            <div>{{ $purchase->supplier?->name ?? '-' }}</div>
        </div>
        <div>
            <div class="text-xs text-[#706f6c]">{{ __('messages.general.branch') }}</div>
            <div>{{ $purchase->branch?->name ?? '-' }}</div>
        </div>
    </div>

    <div class="mt-4 mb-2 flex items-center gap-2">
        <a href="{{ route('vouchers.create', ['type' => 'disbursement', 'amount' => $purchase->total, 'reference_type' => 'purchase', 'reference_id' => $purchase->id, 'cashier_id' => null]) }}"
            class="px-3 py-2 rounded border hover:bg-[#fff2f2]">@lang('messages.voucher.new_disbursement')</a>
    </div>

    <div class="rounded border bg-white overflow-hidden mt-4 max-w-5xl">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-2">{{ __('messages.general.product') }}</th>
                    <th class="p-2">{{ __('messages.general.qty') }}</th>
                    <th class="p-2">{{ __('messages.general.unit_cost') }}</th>
                    <th class="p-2">{{ __('messages.general.line_total') }}</th>
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
        <div>{{ __('messages.general.subtotal') }}: ${{ number_format($purchase->subtotal, 2) }}</div>
        <div>{{ __('messages.general.tax') }}: ${{ number_format($purchase->tax, 2) }}</div>
        <div class="font-semibold">{{ __('messages.general.total') }}: ${{ number_format($purchase->total, 2) }}</div>
    </div>
@endsection
