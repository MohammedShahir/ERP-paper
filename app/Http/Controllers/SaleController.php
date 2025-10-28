<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Inventory;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $branchId = session('branch_id');
        if (!$branchId) {
            return back()->withErrors(['branch' => 'Please select a branch before recording a sale.'])->withInput();
        }

        DB::transaction(function () use ($data, $branchId, &$sale) {
            $subtotal = 0;
            foreach ($data['items'] as $item) {
                $subtotal += $item['unit_price'] * $item['quantity'];
            }
            $tax = round($subtotal * 0.1, 2); // 10% tax example
            $total = $subtotal + $tax;

            $sale = Sale::create([
                'customer_id' => $data['customer_id'] ?? null,
                'branch_id' => $branchId,
                'date' => $data['date'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);

            foreach ($data['items'] as $item) {
                // reduce branch inventory
                $inv = Inventory::lockForUpdate()->firstOrCreate([
                    'product_id' => $item['product_id'],
                    'branch_id' => $branchId,
                ], ['stock' => 0]);
                if ($inv->stock < $item['quantity']) {
                    abort(422, 'Insufficient stock for one or more items.');
                }
                $inv->decrement('stock', (int) $item['quantity']);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['unit_price'] * $item['quantity'],
                ]);
            }

            // Accounting postings: Dr Cash (1000), Cr Sales Revenue (4000), and Dr COGS (5000) Cr Inventory (1100)
            $entry = JournalEntry::create(['date' => $data['date'], 'description' => 'Sale #' . $sale->id]);
            $cash = Account::where('code', '1000')->first();
            $salesRev = Account::where('code', '4000')->first();
            $inventory = Account::where('code', '1100')->first();
            $cogs = Account::where('code', '5000')->first();

            if ($cash && $salesRev) {
                JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => $cash->id, 'debit' => $total, 'credit' => 0]);
                JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => $salesRev->id, 'debit' => 0, 'credit' => $total]);
            }

            // Compute COGS
            $cost = 0;
            foreach ($data['items'] as $item) {
                $prod = Product::find($item['product_id']);
                $cost += ($prod?->cost_price ?? 0) * $item['quantity'];
            }
            if ($cost > 0 && $inventory && $cogs) {
                JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => $cogs->id, 'debit' => $cost, 'credit' => 0]);
                JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => $inventory->id, 'debit' => 0, 'credit' => $cost]);
            }
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded.');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('sales.show', compact('sale'));
    }
}
