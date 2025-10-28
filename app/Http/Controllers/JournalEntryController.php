<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class JournalEntryController extends Controller
{
    public function index()
    {
        $entries = JournalEntry::with('lines.account')->latest('date')->paginate(10);
        return view('accounting.entries.index', compact('entries'));
    }

    public function create()
    {
        $accounts = Account::orderBy('code')->get();
        return view('accounting.entries.create', compact('accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string',
            'lines' => 'required|array|min:2',
            'lines.*.account_id' => 'required|exists:accounts,id',
            'lines.*.debit' => 'nullable|numeric|min:0',
            'lines.*.credit' => 'nullable|numeric|min:0',
        ]);

        $sumDebit = 0;
        $sumCredit = 0;
        foreach ($data['lines'] as $l) {
            $sumDebit += (float)($l['debit'] ?? 0);
            $sumCredit += (float)($l['credit'] ?? 0);
        }
        if (round($sumDebit, 2) !== round($sumCredit, 2)) {
            return back()->withErrors(['lines' => 'Debits must equal credits.'])->withInput();
        }

        DB::transaction(function () use ($data) {
            $entry = JournalEntry::create(['date' => $data['date'], 'description' => $data['description'] ?? null]);
            foreach ($data['lines'] as $l) {
                JournalLine::create([
                    'journal_entry_id' => $entry->id,
                    'account_id' => $l['account_id'],
                    'debit' => $l['debit'] ?? 0,
                    'credit' => $l['credit'] ?? 0,
                ]);
            }
        });

        return redirect()->route('accounting.entries.index')->with('success', 'Journal entry posted.');
    }
}
