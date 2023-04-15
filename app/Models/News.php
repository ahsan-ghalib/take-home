<?php

namespace App\Models;

use App\Enums\CategoryEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'author',
        'category',
        'title',
        'description',
        'content',
        'url',
        'url_to_image',
        'published_at',
        'source',
    ];

    protected $casts = [
        'category' => CategoryEnum::class,
        'source' => 'array',
    ];


    public function publishedAt(): Attribute
    {
        return Attribute::get(fn($value) => Carbon::parse($value)->format('M d, Y H:i:s a'));
    }
}
