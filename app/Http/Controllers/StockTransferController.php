<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::with(['product', 'fromBranch', 'toBranch'])->latest()->paginate(10);
        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        return view('transfers.create', compact('products', 'branches'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'from_branch_id' => 'required|different:to_branch_id|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $from = Inventory::lockForUpdate()->firstOrCreate([
                'product_id' => $data['product_id'],
                'branch_id' => $data['from_branch_id'],
            ], ['stock' => 0]);

            if ($from->stock < $data['quantity']) {
                abort(422, 'Insufficient stock in source branch');
            }

            $to = Inventory::lockForUpdate()->firstOrCreate([
                'product_id' => $data['product_id'],
                'branch_id' => $data['to_branch_id'],
            ], ['stock' => 0]);

            $from->decrement('stock', (int) $data['quantity']);
            $to->increment('stock', (int) $data['quantity']);

            StockTransfer::create($data);
        });

        return redirect()->route('transfers.index')->with('success', 'Stock transferred.');
    }
}
