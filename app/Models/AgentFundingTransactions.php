<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentFundingTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
        "narration",
        "balance_ba",
        "balance_aa",
        "amount",
        "user_id",
        "agent_id",
        "flw_ref",
        "trx_ref",
        "transaction_id",
        "charge_response_code",
        "status",
        "company_ref"
    ];
    protected $hidden = [
        "user_id",
        "id",
        "agent_id"
    ];
}
