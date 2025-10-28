@extends('layouts.app')
@section('title', __('messages.voucher.create'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">@lang('messages.voucher.create')</h1>
    <form action="{{ route('vouchers.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-4xl">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}" />
        <div>
            <label class="block text-sm mb-1">@lang('messages.general.branch')</label>
            <select name="branch_id" class="w-full rounded border p-2" required>
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}" @selected(($prefill['branch_id'] ?? null) == $b->id)>{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">@lang('messages.cashier.title')</label>
            <select name="cashier_id" class="w-full rounded border p-2" required>
                @foreach ($cashiers as $c)
                    <option value="{{ $c->id }}" @selected(($prefill['cashier_id'] ?? null) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">@lang('messages.general.date')</label>
            <input type="date" name="date" value="{{ $prefill['date'] ?? now()->toDateString() }}"
                class="w-full rounded border p-2" required>
        </div>
        <div>
            <label class="block text-sm mb-1">@lang('messages.general.total')</label>
            <input type="number" step="0.01" name="amount" value="{{ $prefill['amount'] ?? '' }}"
                class="w-full rounded border p-2" required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm mb-1">@lang('messages.accounting.account')</label>
            <select name="account_id" class="w-full rounded border p-2">
                <option value="">—</option>
                @foreach ($accounts as $a)
                    <option value="{{ $a->id }}">{{ $a->code }} — {{ $a->name }}</option>
                @endforeach
            </select>
            <p class="text-xs text-[#706f6c] mt-1">@lang('messages.voucher.account_hint')</p>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm mb-1">@lang('messages.accounting.description')</label>
            <textarea name="description" class="w-full rounded border p-2" rows="2"></textarea>
        </div>
        <input type="hidden" name="reference_type" value="{{ $prefill['reference_type'] ?? '' }}" />
        <input type="hidden" name="reference_id" value="{{ $prefill['reference_id'] ?? '' }}" />
        <div class="md:col-span-2 flex items-center gap-2">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="post_journal"
                    {{ empty($prefill['reference_type']) ? 'checked' : '' }}> @lang('messages.voucher.post_journal')</label>
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <a href="{{ route('vouchers.index') }}" class="px-3 py-2 rounded border">@lang('messages.actions.cancel')</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white">@lang('messages.actions.save')</button>
        </div>
    </form>
@endsection
