<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    use HasFactory;
    // this is the part that is listing all the categories
    protected $guarded = [];
    protected $table = 'categories';
    protected $fillable = [

        'id',
        'name',
        'cat'

    ];


    /**
     * Get the Stakes of a Customer
     */
    public function categoryStakes(): HasMany
    {
        return $this->hasMany(Stake::class, "category_id", "id");
    }

    public function winningTags(): HasMany
    {
        return $this->hasMany(WinningTags::class, "category_id", "id");
    }

    public function stake_platform(): HasMany
    {
        return $this->hasMany(WinningTags::class, "winning_tags_id", "id");
    }
}
