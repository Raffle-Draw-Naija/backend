<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifications extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "body",
        "viewed"
    ];


    /**
     * Get the Stakes of a Customer
     */
    public function customers(): BelongsTo
    {
        return $this->belongsTo(NewCustomer::class, "customer_id");
    }


    /**
     * Get the Stakes of a Customer
     */
    public function customerStake(): BelongsTo
    {
        return $this->belongsTo(Stake::class, "stake_id");
    }
}
