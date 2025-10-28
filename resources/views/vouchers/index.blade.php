@extends('layouts.app')
@section('title', __('messages.voucher.title'))
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">@lang('messages.voucher.title')</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('vouchers.create', ['type' => 'collection']) }}"
                class="px-3 py-2 rounded bg-[#1b1b18] text-white">@lang('messages.voucher.new_collection')</a>
            <a href="{{ route('vouchers.create', ['type' => 'disbursement']) }}"
                class="px-3 py-2 rounded bg-[#1b1b18] text-white">@lang('messages.voucher.new_disbursement')</a>
        </div>
    </div>

    <form method="GET" class="mb-3 flex items-end gap-2">
        <div>
            <label class="block text-sm mb-1">@lang('messages.cashier.title')</label>
            <select name="cashier_id" class="rounded border p-2">
                <option value="">—</option>
                @foreach ($cashiers as $c)
                    <option value="{{ $c->id }}" @selected($cashierId == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="px-3 py-2 rounded border">@lang('messages.accounting.filter')</button>
    </form>

    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">@lang('messages.general.date')</th>
                    <th class="p-3">@lang('messages.voucher.type')</th>
                    <th class="p-3">@lang('messages.cashier.title')</th>
                    <th class="p-3">@lang('messages.accounting.account')</th>
                    <th class="p-3">@lang('messages.general.total')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $v)
                    <tr class="border-t">
                        <td class="p-3">{{ $v->date->toDateString() }}</td>
                        <td class="p-3">{{ $v->type }}</td>
                        <td class="p-3">{{ $v->cashier?->name }}</td>
                        <td class="p-3">{{ $v->account?->code }} {{ $v->account?->name }}</td>
                        <td class="p-3">${{ number_format($v->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $vouchers->links() }}</div>
@endsection
