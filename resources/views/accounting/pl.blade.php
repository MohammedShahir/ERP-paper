@extends('layouts.app')
@section('title', 'Profit & Loss')
@section('content')
    <h1 class="text-xl font-semibold mb-4">Profit & Loss</h1>
    <form method="GET" class="flex items-end gap-3 mb-4">
        <div><label class="block text-sm mb-1">From</label><input type="date" name="from" value="{{ $from }}"
                class="rounded border p-2"></div>
        <div><label class="block text-sm mb-1">To</label><input type="date" name="to" value="{{ $to }}"
                class="rounded border p-2"></div>
        <button class="px-3 py-2 rounded border">Filter</button>
        <a href="{{ route('accounting.entries.create') }}" class="ml-auto px-3 py-2 rounded bg-[#1b1b18] text-white">New
            Journal Entry</a>
    </form>

    <div class="max-w-xl rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <tbody>
                <tr class="border-b">
                    <td class="p-3">Revenue</td>
                    <td class="p-3 text-right">${{ number_format($totals['revenue'], 2) }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-3">Expenses (incl. COGS)</td>
                    <td class="p-3 text-right">${{ number_format($totals['expense'], 2) }}</td>
                </tr>
                <tr class="font-semibold">
                    <td class="p-3">Net Profit</td>
                    <td class="p-3 text-right">${{ number_format($profit, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
