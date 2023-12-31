<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentRaffleBookingTransactions extends Model
{
    use HasFactory;

    protected $fillable = [
      "narration",
      "balance_bd",
      "balance_ad",
      "amount",
      "user_id",
      "agent_id"
    ];
    protected $hidden = [
        "user_id",
        "id",
        "agent_id"
    ];
}
