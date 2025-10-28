<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebar: true }" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mini ERP') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen h-full">
    <div class="min-h-screen flex">
        <aside class="hidden md:block w-64 bg-white border-r border-[#e3e3e0] p-4 space-y-2">
            <div class="text-xl font-semibold">Mini ERP</div>
            <nav class="mt-4 space-y-1">
                <div class="text-xs uppercase text-[#706f6c] px-3">General</div>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Dashboard</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Products</a>
                <a href="{{ route('customers.index') }}"
                    class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Customers</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">Sales Department</div>
                <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Sales</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">Procurement Department</div>
                <a href="{{ route('purchases.index') }}"
                    class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Purchases</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">Warehouse Department</div>
                <a href="{{ route('transfers.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Stock
                    Transfers</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">Accounting</div>
                <a href="{{ route('accounting.pl') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Profit &
                    Loss</a>
                <a href="{{ route('accounting.entries.index') }}"
                    class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Journal Entries</a>
                <div class="text-xs uppercase text-[#706f6c] px-3 mt-4">Administration</div>
                <a href="{{ route('branches.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Branches</a>
            </nav>
        </aside>
        <div class="flex-1">
            <header class="bg-white border-b border-[#e3e3e0]">
                <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
                    <div class="md:hidden">
                        <button @click="sidebar = !sidebar"
                            class="px-3 py-2 rounded border hover:bg-[#fff2f2]">Menu</button>
                    </div>
                    <div class="font-medium">@yield('title', 'Mini ERP')</div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('branches.switch') }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @php($allBranches = \App\Models\Branch::orderBy('name')->get())
                            <select name="branch_id" class="border rounded p-1 text-sm" onchange="this.form.submit()">
                                <option value="">No branch</option>
                                @foreach ($allBranches as $b)
                                    <option value="{{ $b->id }}" @selected(session('branch_id') == $b->id)>
                                        {{ $b->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </header>
            <div class="md:hidden" x-show="sidebar" x-transition>
                <nav class="bg-white border-b border-[#e3e3e0] p-2 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Dashboard</a>
                    <a href="{{ route('products.index') }}"
                        class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Products</a>
                    <a href="{{ route('customers.index') }}"
                        class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Customers</a>
                    <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Sales</a>
                    <a href="{{ route('purchases.index') }}"
                        class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Purchases</a>
                    <a href="{{ route('transfers.index') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Stock
                        Transfers</a>
                    <a href="{{ route('accounting.pl') }}" class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Profit &
                        Loss</a>
                    <a href="{{ route('accounting.entries.index') }}"
                        class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Journal Entries</a>
                    <a href="{{ route('branches.index') }}"
                        class="block px-3 py-2 rounded hover:bg-[#fff2f2]">Branches</a>
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
