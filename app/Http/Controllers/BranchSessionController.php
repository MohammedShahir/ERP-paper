<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BranchSessionController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(['branch_id' => 'nullable|exists:branches,id']);
        if (isset($data['branch_id'])) {
            session(['branch_id' => (int) $data['branch_id']]);
        } else {
            session()->forget('branch_id');
        }
        return back()->with('success', 'Branch switched.');
    }
}
