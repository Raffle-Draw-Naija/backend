<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewCustomer extends Model
{
    use HasFactory;

    protected $table = "users";

    protected $fillable =[
        'first_name',
        'last_name',
        'identity',
        'verified',
        'phone',
        'username',
        'password'
    ];

    
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

