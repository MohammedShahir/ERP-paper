<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('name')->paginate(10);
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code',
            'address' => 'nullable|string',
        ]);
        Branch::create($data);
        return redirect()->route('branches.index')->with('success', 'Branch created.');
    }

    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
            'address' => 'nullable|string',
        ]);
        $branch->update($data);
        return redirect()->route('branches.index')->with('success', 'Branch updated.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted.');
    }
}
