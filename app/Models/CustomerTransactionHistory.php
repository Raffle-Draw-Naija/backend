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
    protected $fillable = [
        "amount_bt",
        "amount_at",
        "user_id",
        "transaction_type",
        "amount",
        "description",
        "customer_id",
        "ids",
        "status",
        "role",
    ];
    protected $hidden = ['user_id', 'id', 'customer_id'];
    public function users(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }
    public function customers(): BelongsTo
    {
        return $this->belongsTo('App\Models\NewCustomer', "customer_id");
    }
    public function agents(): BelongsTo
    {
        return $this->belongsTo('App\Models\Agents', "customer_id");
    }
}
