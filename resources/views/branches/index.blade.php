@extends('layouts.app')
@section('title', 'Branches')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Branches</h1>
        <a href="{{ route('branches.create') }}" class="px-3 py-2 rounded bg-[#1b1b18] text-white">Add Branch</a>
    </div>
    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Code</th>
                    <th class="p-3">Address</th>
                    <th class="p-3 w-40"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $b)
                    <tr class="border-t">
                        <td class="p-3">{{ $b->name }}</td>
                        <td class="p-3">{{ $b->code }}</td>
                        <td class="p-3">{{ $b->address }}</td>
                        <td class="p-3 text-right space-x-2">
                            <a class="underline text-[#f53003]" href="{{ route('branches.edit', $b) }}">Edit</a>
                            <form class="inline" method="POST" action="{{ route('branches.destroy', $b) }}">@csrf
                                @method('DELETE')
                                <button class="underline text-[#f53003]"
                                    onclick="return confirm('Delete this branch?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $branches->links() }}</div>
@endsection
