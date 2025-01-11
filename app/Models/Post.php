<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory , HasApiTokens;

    protected $guarded = [];

    protected $fillable = [
        'title',
        'description',
        'image'
    ];
}

