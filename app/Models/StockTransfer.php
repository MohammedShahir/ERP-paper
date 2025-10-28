<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransfer extends Model
{
    protected $fillable = ['product_id', 'from_branch_id', 'to_branch_id', 'quantity', 'date', 'note'];
    protected $casts = ['date' => 'date'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function fromBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }
    public function toBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }
}
