<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNewsFeedPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source',
        'category',
        'author',
    ];

    protected $casts = [
        'source' => 'array',
        'category' => 'array',
        'author' => 'array',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];
}
