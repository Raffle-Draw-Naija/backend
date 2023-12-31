<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StakePlatform extends Model
{
    use HasFactory;

    protected $fillable = [
        "platform_ref",
        "winning_tags_id",
        "start_day",
        "month",
        "year",
        "stake_price",
        "is_close",
        "win_nos",
        "is_open",
        "count_winners",
        "max_winner_count",
        "start_date",
        "end_date",
        "stake_id",
        "category_id"
    ];


    protected $hidden = [
        "id",
    ];
    public function winningTags(): BelongsTo
    {
        return $this->belongsTo(WinningTags::class, "winning_tags_id", "id");
    }


    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, "category_id", "id");
    }
}
