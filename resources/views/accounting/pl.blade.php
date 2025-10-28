@extends('layouts.app')
@section('title', __('messages.accounting.pl'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">{{ __('messages.accounting.pl') }}</h1>
    <form method="GET" class="flex items-end gap-3 mb-4">
        <div><label class="block text-sm mb-1">{{ __('messages.accounting.from') }}</label><input type="date" name="from"
                value="{{ $from }}" class="rounded border p-2"></div>
        <div><label class="block text-sm mb-1">{{ __('messages.accounting.to') }}</label><input type="date" name="to"
                value="{{ $to }}" class="rounded border p-2"></div>
        <button class="px-3 py-2 rounded border">{{ __('messages.accounting.filter') }}</button>
        <a href="{{ route('accounting.entries.create') }}"
            class="ml-auto px-3 py-2 rounded bg-[#1b1b18] text-white">{{ __('messages.accounting.new_journal_entry') }}</a>
    </form>

    <div class="max-w-xl rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <tbody>
                <tr class="border-b">
                    <td class="p-3">{{ __('messages.accounting.revenue') }}</td>
                    <td class="p-3 text-right">${{ number_format($totals['revenue'], 2) }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-3">{{ __('messages.accounting.expenses_incl_cogs') }}</td>
                    <td class="p-3 text-right">${{ number_format($totals['expense'], 2) }}</td>
                </tr>
                <tr class="font-semibold">
                    <td class="p-3">{{ __('messages.accounting.net_profit') }}</td>
                    <td class="p-3 text-right">${{ number_format($profit, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
