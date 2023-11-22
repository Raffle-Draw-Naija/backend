<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Withdrawals extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user(): BelongsTo
    {
        return $this->BelongsTo('App\Models\User', "user_id");
    }

    public function customer(): BelongsTo
    {
        return $this->BelongsTo('App\Models\NewCustomer', "user_id");
    }
    public function bankAccount(): BelongsTo
    {
        return $this->BelongsTo('App\Models\BankAccount', "user_id");
    }
}
