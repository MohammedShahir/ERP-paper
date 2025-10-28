@extends('layouts.app')
@section('title', __('messages.cashier.statement'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">@lang('messages.cashier.statement') — {{ $cashier->name }}</h1>

    <form method="GET" class="flex flex-wrap items-end gap-3 mb-4">
        <div>
            <label class="block text-sm mb-1">@lang('messages.accounting.from')</label>
            <input type="date" name="from" value="{{ $from }}" class="rounded border p-2">
        </div>
        <div>
            <label class="block text-sm mb-1">@lang('messages.accounting.to')</label>
            <input type="date" name="to" value="{{ $to }}" class="rounded border p-2">
        </div>
        <button class="px-3 py-2 rounded border">@lang('messages.accounting.filter')</button>
        <div class="ml-auto flex items-center gap-2">
            <a href="?period=daily" class="px-3 py-2 rounded border">@lang('messages.statement.daily')</a>
            <a href="?period=monthly" class="px-3 py-2 rounded border">@lang('messages.statement.monthly')</a>
            <a href="?period=annual" class="px-3 py-2 rounded border">@lang('messages.statement.annual')</a>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <div class="rounded border bg-white p-3">
            <div class="text-sm text-[#706f6c]">@lang('messages.statement.opening')</div>
            <div class="font-semibold">${{ number_format($opening, 2) }}</div>
        </div>
        <div class="rounded border bg-white p-3">
            <div class="text-sm text-[#706f6c]">@lang('messages.statement.in')</div>
            <div class="font-semibold">${{ number_format($in, 2) }}</div>
        </div>
        <div class="rounded border bg-white p-3">
            <div class="text-sm text-[#706f6c]">@lang('messages.statement.out')</div>
            <div class="font-semibold">${{ number_format($out, 2) }}</div>
        </div>
        <div class="rounded border bg-white p-3">
            <div class="text-sm text-[#706f6c]">@lang('messages.statement.closing')</div>
            <div class="font-semibold">${{ number_format($closing, 2) }}</div>
        </div>
    </div>

    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-2">@lang('messages.general.date')</th>
                    <th class="p-2">@lang('messages.voucher.type')</th>
                    <th class="p-2">@lang('messages.accounting.description')</th>
                    <th class="p-2">@lang('messages.statement.in')</th>
                    <th class="p-2">@lang('messages.statement.out')</th>
                    <th class="p-2">@lang('messages.statement.balance')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tx as $t)
                    <tr class="border-t">
                        <td class="p-2">{{ $t->date->toDateString() }}</td>
                        <td class="p-2">{{ $t->type }}</td>
                        <td class="p-2">{{ $t->description }}</td>
                        <td class="p-2">{{ $t->is_inflow ? '$' . number_format($t->amount, 2) : '' }}</td>
                        <td class="p-2">{{ !$t->is_inflow ? '$' . number_format($t->amount, 2) : '' }}</td>
                        <td class="p-2">${{ number_format($t->running_balance, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
