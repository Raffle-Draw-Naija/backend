<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stake extends Model
{
    use HasFactory;

    protected $table="customers_stakes";

    protected $fillable = [

        'user_id',
        'ticket_id',
        'sub_cat_id',
        'stake_price',
        'stake_number',
        'win',
        'month',
        'year'

    ];


    /**
     * Get the Stakes of a Customer
     */
    public function customers(): BelongsTo
    {
        return $this->belongsTo(NewCustomer::class, "user_id");
    }

    /**
     * Get the Stakes of a Customer
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, "category_id");
    }

    /**
     * Get the Stakes of a Customer
     */
    public function subCategories(): BelongsTo
    {
        return $this->belongsTo(SubCategories::class, "user_id");
    }

    /**
     * Get the Stakes of a Customer
     */
    public function winningTags(): BelongsTo
    {
        return $this->belongsTo(WinningTags::class, "winning_tags_id");
    }


    /**
     * Get the Stakes of a Customer
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notifications::class, "stake_id");
    }
}
