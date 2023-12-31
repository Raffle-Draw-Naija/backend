<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentTransactionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "transaction_type",
        "amount",
        "description",
        "agent_id",
        "transaction_ref",
        "status",
        "role",
        "ids"
    ];
    protected $table = "agent_transaction_history";
    public function agents(): BelongsTo
    {
        return $this->belongsTo('App\Models\Agents', "agent_id");
    }

    protected $hidden = [
        "user_id",
        "agent_id",
        "role",
        "id"
    ];
}
