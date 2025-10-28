@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="rounded border border-[#e3e3e0] bg-white p-4 shadow-sm">
            <div class="text-sm text-[#706f6c]">Products</div>
            <div class="text-2xl font-semibold">{{ $stats['products'] }}</div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4 shadow-sm">
            <div class="text-sm text-[#706f6c]">Customers</div>
            <div class="text-2xl font-semibold">{{ $stats['customers'] }}</div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4 shadow-sm">
            <div class="text-sm text-[#706f6c]">Sales</div>
            <div class="text-2xl font-semibold">{{ $stats['sales'] }}</div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4 shadow-sm">
            <div class="text-sm text-[#706f6c]">Revenue</div>
            <div class="text-2xl font-semibold">${{ number_format($stats['revenue'], 2) }}</div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 rounded border border-[#e3e3e0] bg-white p-4">
            <div class="flex items-center justify-between">
                <h2 class="font-medium">Recent Sales</h2>
                <a href="{{ route('sales.index') }}" class="text-[#f53003] underline">View all</a>
            </div>
            <div class="mt-3 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-[#706f6c]">
                            <th class="py-2">Date</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentSales as $sale)
                            <tr class="border-t">
                                <td class="py-2">{{ $sale->date->format('Y-m-d') }}</td>
                                <td class="py-2">{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                <td class="py-2">${{ number_format($sale->total, 2) }}</td>
                                <td class="py-2 text-right">
                                    <a href="{{ route('sales.show', $sale) }}" class="text-[#f53003] underline">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-[#706f6c]">No sales yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="rounded border border-[#e3e3e0] bg-white p-4" x-data="{ open: true }">
            <div class="flex items-center justify-between">
                <h2 class="font-medium">Low Stock</h2>
                <button @click="open = !open" class="text-sm text-[#706f6c]">Toggle</button>
            </div>
            <ul class="mt-3 space-y-2" x-show="open" x-transition>
                @forelse ($lowStock as $p)
                    <li class="flex justify-between text-sm">
                        <span>{{ $p->name }}</span>
                        <span class="text-[#f53003]">{{ $p->stock }}</span>
                    </li>
                @empty
                    <li class="text-[#706f6c] text-sm">All good!</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
