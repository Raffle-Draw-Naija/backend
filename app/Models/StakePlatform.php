<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StakePlatform extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function winningTags(): BelongsTo
    {
        return $this->belongsTo(WinningTags::class, "winning_tags_id", "id");
    }


    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, "category_id", "id");
    }
}
