<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cashier extends Model
{
    protected $fillable = ['branch_id', 'name', 'code', 'opening_balance', 'active'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(CashierTransaction::class);
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(CashVoucher::class);
    }
}
