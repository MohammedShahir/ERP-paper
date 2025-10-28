@extends('layouts.app')
@section('title', __('messages.branch.edit'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">{{ __('messages.branch.edit') }}</h1>
    <form action="{{ route('branches.update', $branch) }}" method="POST"
        class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">@csrf @method('PUT')
        <div><label class="block text-sm mb-1">{{ __('messages.branch.name') }}</label><input name="name"
                value="{{ old('name', $branch->name) }}" class="w-full rounded border p-2" required></div>
        <div><label class="block text-sm mb-1">{{ __('messages.branch.code') }}</label><input name="code"
                value="{{ old('code', $branch->code) }}" class="w-full rounded border p-2" required></div>
        <div class="md:col-span-2"><label class="block text-sm mb-1">{{ __('messages.branch.address') }}</label><input
                name="address" value="{{ old('address', $branch->address) }}" class="w-full rounded border p-2"></div>
        <div class="md:col-span-2 flex items-center gap-2"><a href="{{ route('branches.index') }}"
                class="px-3 py-2 rounded border">{{ __('messages.actions.cancel') }}</a><button
                class="px-3 py-2 rounded bg-[#1b1b18] text-white">{{ __('messages.actions.update') }}</button></div>
    </form>
@endsection
