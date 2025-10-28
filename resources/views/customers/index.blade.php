@extends('layouts.app')
@section('title', 'Customers')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Customers</h1>
        <a href="{{ route('customers.create') }}" class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">Add
            Customer</a>
    </div>

    <div class="rounded border border-[#e3e3e0] bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Address</th>
                    <th class="p-3 w-40"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $c)
                    <tr class="border-t">
                        <td class="p-3">{{ $c->name }}</td>
                        <td class="p-3">{{ $c->email }}</td>
                        <td class="p-3">{{ $c->phone }}</td>
                        <td class="p-3">{{ $c->address }}</td>
                        <td class="p-3 text-right space-x-2">
                            <a href="{{ route('customers.edit', $c) }}" class="text-[#f53003] underline">Edit</a>
                            <form action="{{ route('customers.destroy', $c) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-[#f53003] underline"
                                    onclick="return confirm('Delete this customer?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $customers->links() }}</div>
@endsection
