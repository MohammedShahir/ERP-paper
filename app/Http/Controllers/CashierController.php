<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Cashier;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $cashiers = Cashier::with('branch')->orderBy('name')->paginate(15);
        return view('cashiers.index', compact('cashiers'));
    }

    public function create()
    {
        $branches = Branch::orderBy('name')->get();
        return view('cashiers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric',
            'active' => 'nullable|boolean',
        ]);
        $data['opening_balance'] = $data['opening_balance'] ?? 0;
        $data['active'] = $request->boolean('active', true);
        Cashier::create($data);
        return redirect()->route('cashiers.index');
    }

    public function edit(Cashier $cashier)
    {
        $branches = Branch::orderBy('name')->get();
        return view('cashiers.edit', compact('cashier', 'branches'));
    }

    public function update(Request $request, Cashier $cashier)
    {
        $data = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric',
            'active' => 'nullable|boolean',
        ]);
        $data['opening_balance'] = $data['opening_balance'] ?? 0;
        $data['active'] = $request->boolean('active', true);
        $cashier->update($data);
        return redirect()->route('cashiers.index');
    }

    public function destroy(Cashier $cashier)
    {
        $cashier->delete();
        return redirect()->route('cashiers.index');
    }
}
