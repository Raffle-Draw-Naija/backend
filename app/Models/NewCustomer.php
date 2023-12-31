<?php

namespace App\Models;

use App\Http\Controllers\CustomerStakeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewCustomer extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable =[
        'first_name',
        'last_name',
        'identity',
        'verified',
        'phone',
        'username',
        'password'
    ];

    protected $hidden = [
        "id",
        "user_id",
        "password"
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    /**
     * Get the Stakes of a Customer
     */
    public function customerStakes(): HasMany
    {
        return $this->hasMany(Stake::class, "user_id", "id");
    }


    /**
     * Get the Stakes of a Customer
     */
    public function transactionHistory(): HasMany
    {
        return $this->hasMany(CustomerTransactionHistory::class, "customer_id", "id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
    public function customerWithdrawal(): HasMany
    {
        return $this->HasMany(Withdrawals::class, "customer_id", "id");
    }



    /**
     * Get the Stakes of a Customer
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notifications::class, "stake_id");
    }
}

/**class NewCustomer2 extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $fillable =[
        'first_name',
        'last_name',
        'phone'
    ];


}**/

