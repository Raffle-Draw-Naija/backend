<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerTransactionHistory extends Model
{
    use HasFactory;

    protected $table = "customer_transaction_history";
    protected $guarded = [];

    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }
    public function customers(): BelongsTo
    {
        return $this->belongsTo('App\Models\NewCustomer', "customer_id");
    }
}
