@extends('layouts.app')
@section('title', 'Edit Customer')
@section('content')
    <h1 class="text-xl font-semibold mb-4">Edit Customer</h1>
    <form action="{{ route('customers.update', $customer) }}" method="POST"
        class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm mb-1">Name</label>
            <input name="name" value="{{ old('name', $customer->name) }}" class="w-full rounded border border-[#e3e3e0] p-2"
                required />
        </div>
        <div>
            <label class="block text-sm mb-1">Email</label>
            <input name="email" type="email" value="{{ old('email', $customer->email) }}"
                class="w-full rounded border border-[#e3e3e0] p-2" />
        </div>
        <div>
            <label class="block text-sm mb-1">Phone</label>
            <input name="phone" value="{{ old('phone', $customer->phone) }}"
                class="w-full rounded border border-[#e3e3e0] p-2" />
        </div>
        <div>
            <label class="block text-sm mb-1">Address</label>
            <input name="address" value="{{ old('address', $customer->address) }}"
                class="w-full rounded border border-[#e3e3e0] p-2" />
        </div>
        <div class="md:col-span-2 flex items-center gap-2">
            <a href="{{ route('customers.index') }}" class="px-3 py-2 rounded border">Cancel</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">Update</button>
        </div>
    </form>
@endsection
