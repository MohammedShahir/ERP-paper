<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalLine;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AccountingController extends Controller
{
    public function profitAndLoss(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->endOfMonth()->toDateString());

        $lines = JournalLine::with('account')
            ->whereHas('entry', fn($q) => $q->whereBetween('date', [$from, $to]))
            ->get();

        $totals = [
            'revenue' => 0,
            'cogs' => 0,
            'expense' => 0,
        ];

        foreach ($lines as $l) {
            $type = $l->account->type;
            $amount = $l->credit - $l->debit; // natural credit for revenue, negative for expenses
            if ($type === 'revenue') $totals['revenue'] += $amount;
            if ($type === 'expense') $totals['expense'] += -$amount; // debit nature
        }

        // If you track COGS in expense type, it is part of expense already
        $profit = $totals['revenue'] - $totals['expense'];

        return view('accounting.pl', [
            'from' => $from,
            'to' => $to,
            'totals' => $totals,
            'profit' => $profit,
        ]);
    }
}
