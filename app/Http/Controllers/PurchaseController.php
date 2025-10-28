<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'branch'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        return view('purchases.create', compact('suppliers', 'products', 'branches'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            $subtotal = 0;
            foreach ($validated['items'] as $it) {
                $subtotal += $it['quantity'] * $it['unit_cost'];
            }
            $tax = 0; // adjust if VAT applicable
            $total = $subtotal + $tax;

            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'] ?? null,
                'branch_id' => $validated['branch_id'],
                'date' => $validated['date'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);

            foreach ($validated['items'] as $it) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $it['product_id'],
                    'quantity' => $it['quantity'],
                    'unit_cost' => $it['unit_cost'],
                    'line_total' => $it['quantity'] * $it['unit_cost'],
                ]);

                // increment inventory in branch
                $inv = Inventory::firstOrCreate([
                    'product_id' => $it['product_id'],
                    'branch_id' => $validated['branch_id'],
                ], ['stock' => 0]);
                $inv->increment('stock', (int) $it['quantity']);

                // update product cost to latest
                Product::where('id', $it['product_id'])->update(['cost_price' => $it['unit_cost']]);
            }

            // Accounting: Dr Inventory, Cr Cash
            $this->postJournal(
                date: Carbon::parse($purchase->date)->toDateString(),
                description: 'Purchase #' . $purchase->id,
                lines: [
                    ['code' => '1100', 'type' => 'debit', 'amount' => $total], // Inventory
                    ['code' => '1000', 'type' => 'credit', 'amount' => $total], // Cash
                ]
            );

            return redirect()->route('purchases.index')->with('success', 'Purchase recorded.');
        });
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'branch', 'items.product']);
        return view('purchases.show', compact('purchase'));
    }

    private function postJournal(string $date, string $description, array $lines): void
    {
        $entry = JournalEntry::create(['date' => $date, 'description' => $description]);
        foreach ($lines as $l) {
            $account = Account::where('code', $l['code'])->first();
            if (!$account) {
                continue;
            }
            JournalLine::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $account->id,
                'debit' => $l['type'] === 'debit' ? $l['amount'] : 0,
                'credit' => $l['type'] === 'credit' ? $l['amount'] : 0,
            ]);
        }
    }
}
