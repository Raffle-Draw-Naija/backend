<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentStakes extends Model
{
    use HasFactory;

    protected $fillable = [
       "user_id",
       "ticket_id",
       "stake_price",
       "stake_number",
       "win",
       "month",
       "year",
       "winning_tags_id",
       "category_id",
       "agent_id",
       "active",
       "stake_platform_id",
    ];

    protected $hidden = [
        "user_id",
        "agent_id",
        "role",
        "id"
    ];


    public function winningTags(): BelongsTo
    {
        return $this->belongsTo(WinningTags::class, "winning_tags_id", "id");
    }
}
