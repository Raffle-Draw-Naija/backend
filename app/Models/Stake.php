<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
