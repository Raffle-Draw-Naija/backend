<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agents extends Model
{
    use HasFactory;

    protected $fillable = [
        "first_name",
        "last_name",
        "phone",
        "address",
        "wallet",
        "user_id"
    ];
    protected $hidden = [
        "id"
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }
    public function agentTransactions(): HasMany
    {
        return $this->hasMany('App\Models\AgentTransactionHistory', "agent_id");
    }
}
