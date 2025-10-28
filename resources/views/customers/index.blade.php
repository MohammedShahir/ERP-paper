@extends('layouts.app')
@section('title', __('messages.customer.title'))
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">{{ __('messages.customer.title') }}</h1>
        <a href="{{ route('customers.create') }}"
            class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">{{ __('messages.customer.add') }}</a>
    </div>

    <div class="rounded border border-[#e3e3e0] bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">{{ __('messages.customer.name') }}</th>
                    <th class="p-3">{{ __('messages.customer.email') }}</th>
                    <th class="p-3">{{ __('messages.customer.phone') }}</th>
                    <th class="p-3">{{ __('messages.customer.address') }}</th>
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
                            <a href="{{ route('customers.edit', $c) }}"
                                class="text-[#f53003] underline">{{ __('messages.actions.edit') }}</a>
                            <form action="{{ route('customers.destroy', $c) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-[#f53003] underline"
                                    onclick="return confirm('{{ __('messages.actions.confirm_delete') }}')">{{ __('messages.actions.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $customers->links() }}</div>
@endsection
