<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
}
