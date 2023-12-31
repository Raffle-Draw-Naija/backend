<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "account_number",
        "account_name",
        "bank_code",
        "bank",
        "customer_id",
    ];

    protected $hidden = [
        "id",
        "user_id",
        "customer_id"
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }


    public function customerWithdrawal(): HasMany
    {
        return $this->HasMany(Withdrawals::class, "bank_account_id", "id");
    }
}
