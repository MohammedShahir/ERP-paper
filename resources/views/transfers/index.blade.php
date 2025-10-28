@extends('layouts.app')
@section('title', __('messages.transfer.title'))
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">{{ __('messages.transfer.title') }}</h1>
        <a href="{{ route('transfers.create') }}"
            class="px-3 py-2 rounded bg-[#1b1b18] text-white">{{ __('messages.actions.new_transfer') }}</a>
    </div>
    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">{{ __('messages.general.date') }}</th>
                    <th class="p-3">{{ __('messages.general.product') }}</th>
                    <th class="p-3">{{ __('messages.transfer.from_branch') }}</th>
                    <th class="p-3">{{ __('messages.transfer.to_branch') }}</th>
                    <th class="p-3">{{ __('messages.general.qty') }}</th>
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
