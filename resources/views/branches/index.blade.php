@extends('layouts.app')
@section('title', __('messages.branch.title'))
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">{{ __('messages.branch.title') }}</h1>
        <a href="{{ route('branches.create') }}"
            class="px-3 py-2 rounded bg-[#1b1b18] text-white">{{ __('messages.branch.add') }}</a>
    </div>
    <div class="rounded border bg-white overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-left text-[#706f6c]">
                <tr>
                    <th class="p-3">{{ __('messages.branch.name') }}</th>
                    <th class="p-3">{{ __('messages.branch.code') }}</th>
                    <th class="p-3">{{ __('messages.branch.address') }}</th>
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
                            <a class="underline text-[#f53003]"
                                href="{{ route('branches.edit', $b) }}">{{ __('messages.actions.edit') }}</a>
                            <form class="inline" method="POST" action="{{ route('branches.destroy', $b) }}">@csrf
                                @method('DELETE')
                                <button class="underline text-[#f53003]"
                                    onclick="return confirm('{{ __('messages.actions.confirm_delete') }}')">{{ __('messages.actions.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $branches->links() }}</div>
@endsection
