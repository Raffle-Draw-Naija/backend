<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stake_numbers extends Model
{
    use HasFactory;
    protected $table = 'stake_numbers';
    protected $fillable = [
        'stake_nos',
        
    ];
}
