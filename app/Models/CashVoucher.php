<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashVoucher extends Model
{
    protected $fillable = [
        'cashier_id',
        'branch_id',
        'account_id',
        'type',
        'date',
        'amount',
        'description',
        'reference_type',
        'reference_id',
        'posted_journal'
    ];
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'posted_journal' => 'boolean',
    ];

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
