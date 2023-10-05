<?php

namespace App\Models;

use App\Http\Controllers\CustomerStakeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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


    /**
     * Get the Stakes of a Customer
     */
    public function customerStakes(): HasMany
    {
        return $this->hasMany(Stake::class, "user_id", "id");
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

