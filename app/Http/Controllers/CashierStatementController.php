<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\CashierTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CashierStatementController extends Controller
{
    public function show(Request $request, Cashier $cashier)
    {
        $period = $request->query('period'); // daily|monthly|annual|custom
        $from = $request->query('from');
        $to = $request->query('to');

        if ($period === 'daily') {
            $from = $to = now()->toDateString();
        } elseif ($period === 'monthly') {
            $from = now()->startOfMonth()->toDateString();
            $to = now()->endOfMonth()->toDateString();
        } elseif ($period === 'annual') {
            $from = now()->startOfYear()->toDateString();
            $to = now()->endOfYear()->toDateString();
        } else {
            // custom or default to today
            $from = $from ?: now()->toDateString();
            $to = $to ?: now()->toDateString();
        }

        $tx = CashierTransaction::where('cashier_id', $cashier->id)
            ->whereBetween('date', [$from, $to])
            ->orderBy('date')
            ->orderBy('id')
            ->get();

        $priorBalanceDelta = CashierTransaction::where('cashier_id', $cashier->id)
            ->where('date', '<', $from)
            ->get()
            ->sum(fn($t) => $t->is_inflow ? $t->amount : -$t->amount);

        $opening = $cashier->opening_balance + $priorBalanceDelta;
        $in = $tx->where('is_inflow', true)->sum('amount');
        $out = $tx->where('is_inflow', false)->sum('amount');
        $closing = $opening + $in - $out;

        // Compute running balances
        $running = $opening;
        foreach ($tx as $t) {
            $running += $t->is_inflow ? $t->amount : -$t->amount;
            $t->running_balance = $running;
        }

        return view('cashiers.statement', compact('cashier', 'tx', 'from', 'to', 'opening', 'in', 'out', 'closing'));
    }
}
