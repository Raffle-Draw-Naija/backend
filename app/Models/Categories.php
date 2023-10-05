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
    protected $table = 'Categories';
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
        return $this->hasMany(Stake::class, "user_id", "id");
    }

}
