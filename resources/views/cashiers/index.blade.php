@extends('layouts.app')
@section('title', __('messages.cashier.title'))
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">@lang('messages.cashier.title')</h1>
        <a href="{{ route('cashiers.create') }}" class="px-3 py-2 rounded bg-[#1b1b18] text-white">@lang('messages.cashier.add')</a>
    </div>
    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">@lang('messages.cashier.name')</th>
                    <th class="p-3">@lang('messages.branch.title')</th>
                    <th class="p-3">@lang('messages.cashier.opening')</th>
                    <th class="p-3">@lang('messages.cashier.active')</th>
                    <th class="p-3 w-64"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cashiers as $c)
                    <tr class="border-t">
                        <td class="p-3">{{ $c->name }}</td>
                        <td class="p-3">{{ $c->branch?->name }}</td>
                        <td class="p-3">${{ number_format($c->opening_balance, 2) }}</td>
                        <td class="p-3">{{ $c->active ? '✓' : '✕' }}</td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('cashiers.statement', $c) }}"
                                class="underline text-[#f53003]">@lang('messages.cashier.statement')</a>
                            <a href="{{ route('cashiers.edit', $c) }}"
                                class="underline text-[#f53003]">@lang('messages.actions.edit')</a>
                            <form action="{{ route('cashiers.destroy', $c) }}" method="POST" class="inline">@csrf
                                @method('DELETE')
                                <button class="underline text-[#f53003]"
                                    onclick="return confirm('{{ __('messages.actions.confirm_delete') }}')">@lang('messages.actions.delete')</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $cashiers->links() }}</div>
@endsection
