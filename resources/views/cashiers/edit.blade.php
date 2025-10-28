@extends('layouts.app')
@section('title', __('messages.actions.edit'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">@lang('messages.actions.edit')</h1>
    <form action="{{ route('cashiers.update', $cashier) }}" method="POST"
        class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm mb-1">@lang('messages.branch.title')</label>
            <select name="branch_id" class="w-full rounded border p-2" required>
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}" @selected($cashier->branch_id == $b->id)>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">@lang('messages.cashier.name')</label>
            <input name="name" value="{{ old('name', $cashier->name) }}" class="w-full rounded border p-2" required>
        </div>
        <div>
            <label class="block text-sm mb-1">@lang('messages.cashier.code')</label>
            <input name="code" value="{{ old('code', $cashier->code) }}" class="w-full rounded border p-2">
        </div>
        <div>
            <label class="block text-sm mb-1">@lang('messages.cashier.opening')</label>
            <input type="number" step="0.01" name="opening_balance"
                value="{{ old('opening_balance', $cashier->opening_balance) }}" class="w-full rounded border p-2">
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="active"
                    @checked($cashier->active)> @lang('messages.cashier.active')</label>
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <a href="{{ route('cashiers.index') }}" class="px-3 py-2 rounded border">@lang('messages.actions.cancel')</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white">@lang('messages.actions.update')</button>
        </div>
    </form>
@endsection
