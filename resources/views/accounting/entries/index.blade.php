@extends('layouts.app')
@section('title', 'Journal Entries')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Journal Entries</h1>
        <a href="{{ route('accounting.entries.create') }}" class="px-3 py-2 rounded bg-[#1b1b18] text-white">New Entry</a>
    </div>
    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">Date</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Lines</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $e)
                    <tr class="border-t">
                        <td class="p-3">{{ $e->date->toDateString() }}</td>
                        <td class="p-3">{{ $e->description }}</td>
                        <td class="p-3">
                            <ul>
                                @foreach ($e->lines as $l)
                                    <li>{{ $l->account->code }} {{ $l->account->name }} — Dr
                                        ${{ number_format($l->debit, 2) }} Cr ${{ number_format($l->credit, 2) }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $entries->links() }}</div>
@endsection
