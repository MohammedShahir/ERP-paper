@extends('layouts.app')
@section('title', __('messages.sale.title'))
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">{{ __('messages.sale.title') }}</h1>
        <a href="{{ route('sales.create') }}"
            class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">{{ __('messages.actions.new_sale') }}</a>
    </div>

    <div class="rounded border border-[#e3e3e0] bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">{{ __('messages.general.date') }}</th>
                    <th class="p-3">{{ __('messages.general.customers') }}</th>
                    <th class="p-3">{{ __('messages.general.subtotal') }}</th>
                    <th class="p-3">{{ __('messages.general.tax') }}</th>
                    <th class="p-3">{{ __('messages.general.total') }}</th>
                    <th class="p-3 w-32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $s)
                    <tr class="border-t">
                        <td class="p-3">{{ $s->date->format('Y-m-d') }}</td>
                        <td class="p-3">{{ $s->customer->name ?? __('messages.general.walk_in') }}</td>
                        <td class="p-3">${{ number_format($s->subtotal, 2) }}</td>
                        <td class="p-3">${{ number_format($s->tax, 2) }}</td>
                        <td class="p-3">${{ number_format($s->total, 2) }}</td>
                        <td class="p-3 text-right">
                            <a href="{{ route('sales.show', $s) }}"
                                class="text-[#f53003] underline">{{ __('messages.general.details') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $sales->links() }}</div>
@endsection
