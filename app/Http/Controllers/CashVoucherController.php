<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Branch;
use App\Models\Cashier;
use App\Models\CashierTransaction;
use App\Models\CashVoucher;
use App\Models\JournalEntry;
use App\Models\JournalLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashVoucherController extends Controller
{
    public function index(Request $request)
    {
        $cashierId = $request->query('cashier_id');
        $query = CashVoucher::with(['cashier', 'account'])->latest('date');
        if ($cashierId) {
            $query->where('cashier_id', $cashierId);
        }
        $vouchers = $query->paginate(20)->withQueryString();
        $cashiers = Cashier::orderBy('name')->get();
        return view('vouchers.index', compact('vouchers', 'cashiers', 'cashierId'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'collection');
        abort_unless(in_array($type, ['collection', 'disbursement']), 404);
        $branches = Branch::orderBy('name')->get();
        $cashiers = Cashier::orderBy('name')->get();
        $accounts = Account::orderBy('code')->get();
        $prefill = [
            'cashier_id' => $request->query('cashier_id'),
            'date' => now()->toDateString(),
            'amount' => $request->query('amount'),
            'reference_type' => $request->query('reference_type'),
            'reference_id' => $request->query('reference_id'),
            'branch_id' => session('branch_id'),
        ];
        return view('vouchers.create', compact('type', 'branches', 'cashiers', 'accounts', 'prefill'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:collection,disbursement',
            'cashier_id' => 'required|exists:cashiers,id',
            'branch_id' => 'required|exists:branches,id',
            'account_id' => 'nullable|exists:accounts,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'reference_type' => 'nullable|string',
            'reference_id' => 'nullable|integer',
            'post_journal' => 'nullable|boolean',
        ]);

        $postJournal = $request->boolean('post_journal', true);

        return DB::transaction(function () use ($data, $postJournal) {
            $voucher = CashVoucher::create([
                'type' => $data['type'],
                'cashier_id' => $data['cashier_id'],
                'branch_id' => $data['branch_id'],
                'account_id' => $data['account_id'] ?? null,
                'date' => $data['date'],
                'amount' => $data['amount'],
                'description' => $data['description'] ?? null,
                'reference_type' => $data['reference_type'] ?? null,
                'reference_id' => $data['reference_id'] ?? null,
                'posted_journal' => $postJournal,
            ]);

            // Record cashier transaction
            CashierTransaction::create([
                'cashier_id' => $voucher->cashier_id,
                'date' => $voucher->date,
                'type' => $voucher->type,
                'amount' => $voucher->amount,
                'is_inflow' => $voucher->type === 'collection',
                'reference_type' => $voucher->reference_type,
                'reference_id' => $voucher->reference_id,
                'description' => $voucher->description,
            ]);

            // Post accounting journal only if requested and account is provided
            if ($postJournal && $voucher->account_id) {
                $entry = JournalEntry::create([
                    'date' => $voucher->date,
                    'reference' => 'Voucher #' . $voucher->id,
                    'description' => $voucher->description,
                ]);

                // Find Cash account (assumed code 1000)
                $cashAccount = Account::where('code', '1000')->first();

                if ($voucher->type === 'collection') {
                    // Dr Cash, Cr Selected Account
                    JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => optional($cashAccount)->id ?? $voucher->account_id, 'debit' => $voucher->amount, 'credit' => 0]);
                    JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => $voucher->account_id, 'debit' => 0, 'credit' => $voucher->amount]);
                } else {
                    // Disbursement: Dr Selected Account, Cr Cash
                    JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => $voucher->account_id, 'debit' => $voucher->amount, 'credit' => 0]);
                    JournalLine::create(['journal_entry_id' => $entry->id, 'account_id' => optional($cashAccount)->id ?? $voucher->account_id, 'debit' => 0, 'credit' => $voucher->amount]);
                }
            }

            return redirect()->route('vouchers.index', ['cashier_id' => $voucher->cashier_id]);
        });
    }
}
