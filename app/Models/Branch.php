<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = ['name', 'code', 'address'];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
