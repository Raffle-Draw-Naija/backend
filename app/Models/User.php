<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        "identity",
        "username",
        "verified",
        "password",
        "email",
        "verify_code",
        "password_reset",
        "device_id",
        "role",
        "role",
        "bank_code",
        "pin"
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verify_code'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function bankAccount(): HasOne
    {
        return $this->hasOne('App\Models\BankAccount');
    }

    public function profile(): HasOne
    {
        return $this->hasOne('App\Models\NewCustomer');
    }


    public function customerTransactions(): HasMany
    {
        return $this->hasMany('App\Models\CustomerTransactionHistory', "user_id");
    }

    public function customerWithdrawal(): HasMany
    {
        return $this->hasMany('App\Models\Withdrawals', "user_id");
    }


    public function agents(): HasMany
    {
        return $this->hasMany('App\Models\Agents', "user_id");
    }
}
