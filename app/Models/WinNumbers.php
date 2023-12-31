<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinNumbers extends Model
{
    use HasFactory;

    protected $fillable = [
        "identity",
        "win_num",
        "category_id",
        "winning_tag_id",
        "month",
        "year"
    ];

    protected $hidden = [
        "id"
        ];
}
