@if (session('success'))
    <div data-flash
        class="mb-4 rounded border border-[#e3e3e0] bg-white px-4 py-3 text-sm shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] transition-all">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="mb-4 rounded border border-[#e3e3e0] bg-[#fff2f2] px-4 py-3 text-sm">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
