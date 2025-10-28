<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashierTransaction extends Model
{
    protected $fillable = [
        'cashier_id',
        'date',
        'type',
        'amount',
        'is_inflow',
        'reference_type',
        'reference_id',
        'description'
    ];
    protected $casts = [
        'date' => 'date',
        'is_inflow' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class);
    }
}
