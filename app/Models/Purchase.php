<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'branch_id', 'date', 'subtotal', 'tax', 'total'];
    protected $casts = ['date' => 'date'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
