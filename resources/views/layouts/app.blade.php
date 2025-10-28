<!DOCTYPE html>
@php($isRtl = app()->getLocale() === 'ar')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}" x-data="{ sidebar: true }" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', __('messages.app_name')) }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen h-full">
    <div class="min-h-screen flex">
        <aside class="hidden md:block w-64 bg-white border-r border-[#e3e3e0] p-4 space-y-2">
            <div class="text-xl font-semibold">{{ __('messages.app_name') }}</div>
            <nav class="mt-4 space-y-1">
                <div class="text-xs uppercase text-[#706f6c] px-3">{{ __('messages.general.general') }}</div>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.dashboard') }}</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.products') }}</a>
                <a href="{{ route('customers.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.customers') }}</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">{{ __('messages.general.sales_department') }}</div>
                <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.sales') }}</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">{{ __('messages.general.procurement_department') }}</div>
                <a href="{{ route('purchases.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.purchases') }}</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">{{ __('messages.general.warehouse_department') }}</div>
                <a href="{{ route('transfers.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.transfers') }}</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">{{ __('messages.general.accounting') }}</div>
                <a href="{{ route('accounting.pl') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.pl') }}</a>
                <a href="{{ route('accounting.entries.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.journal_entries') }}</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">{{ __('messages.general.administration') }}</div>
                <a href="{{ route('branches.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.branches') }}</a>
            </nav>
        </aside>
        <div class="flex-1">
            <header class="bg-white border-b border-[#e3e3e0]">
                <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
                    <div class="md:hidden">
                        <button @click="sidebar = !sidebar"
                            class="px-3 py-2 rounded border hover:bg-[#fff2f2]">{{ __('messages.actions.menu') }}</button>
                    </div>
                    <div class="font-medium">@yield('title', __('messages.app_name'))</div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('branches.switch') }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @php($allBranches = \App\Models\Branch::orderBy('name')->get())
                            <select name="branch_id" class="border rounded p-1 text-sm" onchange="this.form.submit()">
                                <option value="">{{ __('messages.general.no_branch') }}</option>
                                @foreach ($allBranches as $b)
                                    <option value="{{ $b->id }}" @selected(session('branch_id') == $b->id)>
                                        {{ $b->name }}</option>
                                @endforeach
                            </select>
                        </form>
                        <form action="{{ route('locale.switch') }}" method="POST">
                            @csrf
                            <input type="hidden" name="locale" value="{{ app()->getLocale() === 'ar' ? 'en' : 'ar' }}" />
                            <button class="px-2 py-1 text-sm border rounded hover:bg-[#fff2f2]">
                                {{ app()->getLocale() === 'ar' ? __('messages.actions.english') : __('messages.actions.arabic') }}
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            <div class="md:hidden" x-show="sidebar" x-transition>
                <nav class="bg-white border-b border-[#e3e3e0] p-2 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.dashboard') }}</a>
                    <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.products') }}</a>
                    <a href="{{ route('customers.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.customers') }}</a>
                    <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.sales') }}</a>
                    <a href="{{ route('purchases.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.purchases') }}</a>
                    <a href="{{ route('transfers.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.transfers') }}</a>
                    <a href="{{ route('accounting.pl') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.pl') }}</a>
                    <a href="{{ route('accounting.entries.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.journal_entries') }}</a>
                    <a href="{{ route('branches.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">{{ __('messages.general.branches') }}</a>
                </nav>
            </div>

            <main class="mx-auto max-w-7xl p-4">
                @include('partials.flash')
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
