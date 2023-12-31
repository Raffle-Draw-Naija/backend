<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Withdrawals extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "customer_id",
        "bank_code",
        "account_name",
        "trx_date",
        "currency",
        "debit_currency",
        "fee",
        "reference",
        "requires_approval",
        "is_approved",
        "customer_id",
        "customer_id",
        "customer_id",
        "bank_account_id",
        "amount",
        "narration",
        "trx_ref",
        "status",
        "bank_name",
        "account_number"
    ];


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
