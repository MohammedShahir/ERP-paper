@extends('layouts.app')
@section('title', 'Purchases')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Purchases</h1>
        <a href="{{ route('purchases.create') }}" class="px-3 py-2 rounded bg-[#1b1b18] text-white">New Purchase</a>
    </div>
    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">Date</th>
                    <th class="p-3">Supplier</th>
                    <th class="p-3">Branch</th>
                    <th class="p-3">Total</th>
                    <th class="p-3 w-40"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchases as $p)
                    <tr class="border-t">
                        <td class="p-3">{{ $p->date->toDateString() }}</td>
                        <td class="p-3">{{ $p->supplier?->name ?? '-' }}</td>
                        <td class="p-3">{{ $p->branch?->name ?? '-' }}</td>
                        <td class="p-3">${{ number_format($p->total, 2) }}</td>
                        <td class="p-3 text-right"><a class="underline text-[#f53003]"
                                href="{{ route('purchases.show', $p) }}">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $purchases->links() }}</div>
@endsection
