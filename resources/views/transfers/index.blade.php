@extends('layouts.app')
@section('title', 'Stock Transfers')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Stock Transfers</h1>
        <a href="{{ route('transfers.create') }}" class="px-3 py-2 rounded bg-[#1b1b18] text-white">New Transfer</a>
    </div>
    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">Date</th>
                    <th class="p-3">Product</th>
                    <th class="p-3">From</th>
                    <th class="p-3">To</th>
                    <th class="p-3">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transfers as $t)
                    <tr class="border-t">
                        <td class="p-3">{{ $t->date->toDateString() }}</td>
                        <td class="p-3">{{ $t->product?->name }}</td>
                        <td class="p-3">{{ $t->fromBranch?->name }}</td>
                        <td class="p-3">{{ $t->toBranch?->name }}</td>
                        <td class="p-3">{{ $t->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $transfers->links() }}</div>
@endsection
