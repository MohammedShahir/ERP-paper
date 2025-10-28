@extends('layouts.app')
@section('title', __('messages.purchase.new'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">{{ __('messages.purchase.new') }}</h1>
    <form action="{{ route('purchases.store') }}" method="POST" x-data="purchaseForm()" class="space-y-4">@csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-5xl">
            <div>
                <label class="block text-sm mb-1">{{ __('messages.general.supplier') }}</label>
                <select name="supplier_id" class="w-full rounded border p-2">
                    <option value="">-- {{ __('messages.general.none') }} --</option>
                    @foreach ($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('messages.general.branch') }}</label>
                <select name="branch_id" class="w-full rounded border p-2" required>
                    @foreach ($branches as $b)
                        <option value="{{ $b->id }}" @selected(session('branch_id') == $b->id)>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('messages.general.date') }}</label>
                <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full rounded border p-2"
                    required>
            </div>
        </div>

        <div class="rounded border bg-white overflow-hidden max-w-5xl">
            <table class="w-full text-sm">
                <thead class="text-left text-[#706f6c]">
                    <tr>
                        <th class="p-2">{{ __('messages.general.product') }}</th>
                        <th class="p-2 w-28">{{ __('messages.general.qty') }}</th>
                        <th class="p-2 w-32">{{ __('messages.general.unit_cost') }}</th>
                        <th class="p-2 w-32">{{ __('messages.general.line_total') }}</th>
                        <th class="p-2 w-10"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(it, idx) in items" :key="idx">
                        <tr class="border-t">
                            <td class="p-2">
                                <select :name="`items[${idx}][product_id]`" class="w-full rounded border p-2"
                                    x-model.number="it.product_id">
                                    <option value="">-- {{ __('messages.general.select') }} --</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->sku }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-2"><input type="number" min="1" class="w-full rounded border p-2"
                                    x-model.number="it.quantity" :name="`items[${idx}][quantity]`"></td>
                            <td class="p-2"><input type="number" step="0.01" min="0"
                                    class="w-full rounded border p-2" x-model.number="it.unit_cost"
                                    :name="`items[${idx}][unit_cost]`"></td>
                            <td class="p-2">$<span x-text="(it.quantity*it.unit_cost).toFixed(2)"></span></td>
                            <td class="p-2 text-right"><button type="button" class="text-[#f53003] underline"
                                    @click="remove(idx)">{{ __('messages.actions.remove') }}</button></td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="p-3"><button type="button" class="px-3 py-2 rounded border"
                    @click="add()">{{ __('messages.actions.add_item') }}</button>
            </div>
        </div>

        <div class="max-w-5xl flex items-center justify-end gap-6 text-sm">
            <div>{{ __('messages.general.subtotal') }}: $<span x-text="subtotal().toFixed(2)"></span></div>
            <div>{{ __('messages.general.tax') }}: $<span x-text="tax().toFixed(2)"></span></div>
            <div class="font-semibold">{{ __('messages.general.total') }}: $<span x-text="total().toFixed(2)"></span></div>
        </div>

        <div class="max-w-5xl flex items-center gap-2">
            <a href="{{ route('purchases.index') }}"
                class="px-3 py-2 rounded border">{{ __('messages.actions.cancel') }}</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white">{{ __('messages.actions.save_purchase') }}</button>
        </div>
    </form>

    <script>
        function purchaseForm() {
            return {
                items: [{
                    product_id: '',
                    quantity: 1,
                    unit_cost: 0
                }],
                add() {
                    this.items.push({
                        product_id: '',
                        quantity: 1,
                        unit_cost: 0
                    });
                },
                remove(i) {
                    this.items.splice(i, 1);
                },
                subtotal() {
                    return this.items.reduce((s, i) => s + (Number(i.quantity) || 0) * (Number(i.unit_cost) || 0), 0);
                },
                tax() {
                    return 0;
                },
                total() {
                    return this.subtotal() + this.tax();
                }
            }
        }
    </script>
@endsection
