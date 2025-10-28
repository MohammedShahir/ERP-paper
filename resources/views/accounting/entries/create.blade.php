@extends('layouts.app')
@section('title', __('messages.accounting.new_journal_entry'))
@section('content')
    <h1 class="text-xl font-semibold mb-4">{{ __('messages.accounting.new_journal_entry') }}</h1>
    <form action="{{ route('accounting.entries.store') }}" method="POST" x-data="entryForm()" class="space-y-4">@csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl">
            <div>
                <label class="block text-sm mb-1">{{ __('messages.accounting.date') }}</label>
                <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full rounded border p-2"
                    required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('messages.accounting.description') }}</label>
                <input name="description" class="w-full rounded border p-2">
            </div>
        </div>
        <div class="rounded border bg-white overflow-hidden max-w-4xl">
            <table class="w-full text-sm">
                <thead class="text-left text-[#706f6c]">
                    <tr>
                        <th class="p-2">{{ __('messages.accounting.account') }}</th>
                        <th class="p-2 w-32">{{ __('messages.accounting.debit') }}</th>
                        <th class="p-2 w-32">{{ __('messages.accounting.credit') }}</th>
                        <th class="p-2 w-10"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(ln, idx) in lines" :key="idx">
                        <tr class="border-t">
                            <td class="p-2">
                                <select :name="`lines[${idx}][account_id]`" class="w-full rounded border p-2"
                                    x-model.number="ln.account_id">
                                    <option value="">-- {{ __('messages.general.select') }} --</option>
                                    @foreach ($accounts as $a)
                                        <option value="{{ $a->id }}">{{ $a->code }} — {{ $a->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-2"><input type="number" step="0.01" min="0"
                                    class="w-full rounded border p-2" x-model.number="ln.debit"
                                    :name="`lines[${idx}][debit]`"></td>
                            <td class="p-2"><input type="number" step="0.01" min="0"
                                    class="w-full rounded border p-2" x-model.number="ln.credit"
                                    :name="`lines[${idx}][credit]`"></td>
                            <td class="p-2 text-right"><button type="button" class="text-[#f53003] underline"
                                    @click="remove(idx)">{{ __('messages.actions.remove') }}</button></td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="p-3"><button type="button" class="px-3 py-2 rounded border"
                    @click="add()">{{ __('messages.actions.add_line') }}</button>
            </div>
        </div>
        <div class="max-w-4xl flex items-center justify-end gap-6 text-sm">
            <div>{{ __('messages.accounting.total_debit') }}: $<span x-text="totalDebit().toFixed(2)"></span></div>
            <div>{{ __('messages.accounting.total_credit') }}: $<span x-text="totalCredit().toFixed(2)"></span></div>
        </div>
        <div class="max-w-4xl flex items-center gap-2">
            <a href="{{ route('accounting.entries.index') }}"
                class="px-3 py-2 rounded border">{{ __('messages.actions.cancel') }}</a>
            <button class="px-3 py-2 rounded bg-[#1b1b18] text-white">{{ __('messages.accounting.post_entry') }}</button>
        </div>
    </form>
    <script>
        function entryForm() {
            return {
                lines: [{
                    account_id: '',
                    debit: 0,
                    credit: 0
                }, {
                    account_id: '',
                    debit: 0,
                    credit: 0
                }],
                add() {
                    this.lines.push({
                        account_id: '',
                        debit: 0,
                        credit: 0
                    });
                },
                remove(i) {
                    this.lines.splice(i, 1);
                },
                totalDebit() {
                    return this.lines.reduce((s, l) => s + (Number(l.debit) || 0), 0);
                },
                totalCredit() {
                    return this.lines.reduce((s, l) => s + (Number(l.credit) || 0), 0);
                },
            }
        }
    </script>
@endsection
