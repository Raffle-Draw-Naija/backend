<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategories extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Get the Stakes of a Sub Categories
     */
    public function subCategoryStakes(): HasMany
    {
        return $this->hasMany(Stake::class, "user_id", "id");
    }


}