@extends('layouts.app')
@section('title', __('messages.transfer.new'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">{{ __('messages.transfer.new') }}</h1>
    <form action="{{ route('transfers.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">@csrf
        <div>
            <label class="block text-sm mb-1">{{ __('messages.general.product') }}</label>
            <select name="product_id" class="w-full rounded border p-2" required>
                @foreach ($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->sku }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.general.qty') }}</label>
            <input type="number" name="quantity" min="1" class="w-full rounded border p-2" required>
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.transfer.from_branch') }}</label>
            <select name="from_branch_id" class="w-full rounded border p-2" required>
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.transfer.to_branch') }}</label>
            <select name="to_branch_id" class="w-full rounded border p-2" required>
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">{{ __('messages.general.date') }}</label>
            <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full rounded border p-2"
                required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm mb-1">{{ __('messages.transfer.note') }}</label>
            <textarea name="note" class="w-full rounded border p-2" rows="2"></textarea>
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <a href="{{ route('transfers.index') }}"
                class="px-3 py-2 rounded border">{{ __('messages.actions.cancel') }}</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white">{{ __('messages.actions.transfer') }}</button>
        </div>
    </form>
@endsection
