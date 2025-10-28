<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = ['name', 'code', 'type'];

    public function lines(): HasMany
    {
        return $this->hasMany(JournalLine::class);
    }
}
