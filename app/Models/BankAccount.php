<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }
}
