@extends('layouts.app')
@section('title', 'New Sale')
@section('content')
    <h1 class="text-xl font-semibold mb-4">New Sale</h1>

    <form action="{{ route('sales.store') }}" method="POST" x-data="saleForm()" x-init="init()" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm mb-1">Customer</label>
                <select name="customer_id" class="w-full rounded border border-[#e3e3e0] p-2">
                    <option value="">Walk-in</option>
                    @foreach ($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Date</label>
                <input type="date" name="date" class="w-full rounded border border-[#e3e3e0] p-2"
                    value="{{ date('Y-m-d') }}" required />
            </div>
        </div>

        <div class="rounded border border-[#e3e3e0] bg-white p-4" x-transition>
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-medium">Items</h2>
                <button type="button" @click="addItem()" class="px-3 py-2 rounded border hover:bg-[#fff2f2]">Add
                    item</button>
            </div>
            <template x-for="(item, idx) in items" :key="idx">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-3 py-2 border-t first:border-t-0">
                    <div class="md:col-span-2">
                        <label class="block text-xs mb-1">Product</label>
                        <select class="w-full rounded border border-[#e3e3e0] p-2" :name="`items[${idx}][product_id]`"
                            x-model.number="item.product_id" @change="applyPrice(idx)">
                            <option value="">Select...</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }}
                                    (Stock: {{ $p->stock }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Qty</label>
                        <input type="number" min="1" class="w-full rounded border border-[#e3e3e0] p-2"
                            :name="`items[${idx}][quantity]`" x-model.number="item.quantity" @input="recalc()" />
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Unit Price</label>
                        <input type="number" step="0.01" min="0"
                            class="w-full rounded border border-[#e3e3e0] p-2" :name="`items[${idx}][unit_price]`"
                            x-model.number="item.unit_price" @input="recalc()" />
                    </div>
                    <div>
                        <label class="block text-xs mb-1">Line Total</label>
                        <input type="text" class="w-full rounded border border-[#e3e3e0] p-2 bg-[#f7f7f5]"
                            :value="format(item.quantity * item.unit_price)" readonly />
                    </div>
                    <div class="flex items-end justify-end">
                        <button type="button" @click="removeItem(idx)"
                            class="px-3 py-2 rounded text-[#f53003] hover:underline">Remove</button>
                    </div>
                </div>
            </template>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2"></div>
            <div class="rounded border border-[#e3e3e0] bg-white p-4 space-y-1">
                <div class="flex justify-between text-sm"><span>Subtotal</span><span x-text="format(subtotal)"></span></div>
                <div class="flex justify-between text-sm"><span>Tax (10%)</span><span x-text="format(tax)"></span></div>
                <div class="flex justify-between text-base font-semibold"><span>Total</span><span
                        x-text="format(total)"></span></div>
            </div>
        </div>

        <template x-for="(item, idx) in items" hidden>
            <div>
                <input type="hidden" :name="`items[${idx}][product_id]`" :value="item.product_id" />
                <input type="hidden" :name="`items[${idx}][quantity]`" :value="item.quantity" />
                <input type="hidden" :name="`items[${idx}][unit_price]`" :value="item.unit_price" />
            </div>
        </template>

        <div class="flex items-center gap-2">
            <a href="{{ route('sales.index') }}" class="px-3 py-2 rounded border">Cancel</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white hover:bg-black">Save Sale</button>
        </div>
    </form>

    <script>
        function saleForm() {
            return {
                items: [],
                subtotal: 0,
                tax: 0,
                total: 0,
                init() {
                    this.addItem();
                },
                addItem() {
                    this.items.push({
                        product_id: '',
                        quantity: 1,
                        unit_price: 0
                    });
                    this.$nextTick(() => this.recalc());
                },
                removeItem(idx) {
                    this.items.splice(idx, 1);
                    this.recalc();
                },
                applyPrice(idx) {
                    const select = this.$root.querySelectorAll('select')[idx + 1];
                    const price = select?.selectedOptions?.[0]?.getAttribute('data-price');
                    if (price) {
                        this.items[idx].unit_price = parseFloat(price);
                    }
                    this.recalc();
                },
                recalc() {
                    this.subtotal = this.items.reduce((s, it) => s + (Number(it.quantity || 0) * Number(it.unit_price ||
                        0)), 0);
                    this.tax = Math.round(this.subtotal * 0.10 * 100) / 100;
                    this.total = this.subtotal + this.tax;
                },
                format(v) {
                    return `$${Number(v||0).toFixed(2)}`;
                }
            }
        }
    </script>
@endsection
