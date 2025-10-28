@extends('layouts.app')
@section('title', 'New Transfer')
@section('content')
    <h1 class="text-xl font-semibold mb-4">New Stock Transfer</h1>
    <form action="{{ route('transfers.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">@csrf
        <div>
            <label class="block text-sm mb-1">Product</label>
            <select name="product_id" class="w-full rounded border p-2" required>
                @foreach ($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->sku }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Quantity</label>
            <input type="number" name="quantity" min="1" class="w-full rounded border p-2" required>
        </div>
        <div>
            <label class="block text-sm mb-1">From Branch</label>
            <select name="from_branch_id" class="w-full rounded border p-2" required>
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">To Branch</label>
            <select name="to_branch_id" class="w-full rounded border p-2" required>
                @foreach ($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1">Date</label>
            <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full rounded border p-2"
                required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm mb-1">Note</label>
            <textarea name="note" class="w-full rounded border p-2" rows="2"></textarea>
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <a href="{{ route('transfers.index') }}" class="px-3 py-2 rounded border">Cancel</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white">Transfer</button>
        </div>
    </form>
@endsection
