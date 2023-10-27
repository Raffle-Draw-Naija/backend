<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WinningTags extends Model
{
    use HasFactory;

    protected $guarded = [];



    /**
     * Get the Stakes of a Sub Categories
     */
    public function winningTagsStakes(): HasMany
    {
        return $this->hasMany(Stake::class, "user_id", "id");
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, "category_id", "id");
    }

    public function stake_platform(): HasMany
    {
        return $this->hasMany(StakePlatform::class, "winning_tags_id", "id");
    }

}
