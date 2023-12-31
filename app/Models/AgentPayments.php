<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPayments extends Model
{
    use HasFactory;

    protected $fillable = [
      "amount",
      "company_ref",
      "flw_ref",
      "trx_ref",
      "status",
      "transaction_id",
      "charge_response_code",
      "user_id",
      "agent_id"
    ];

    protected $hidden = [
        "user_id",
        "id",
        "agent_id"
    ];
}
