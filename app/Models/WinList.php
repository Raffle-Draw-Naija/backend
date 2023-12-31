<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinList extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'win',
    ];

    protected $hidden = [
        "id"
    ];
}
