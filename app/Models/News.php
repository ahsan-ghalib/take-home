<?php

namespace App\Models;

use App\Enums\CategoryEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class News extends Model
{
    use HasFactory, SoftDeletes;

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
        'scraped_from',
    ];

    protected $casts = [
        'category' => CategoryEnum::class,
        'source' => 'array',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];


    public function publishedAt(): Attribute
    {
        return Attribute::get(fn($value) => Carbon::parse($value)->format('M d, Y H:i:s a'));
    }
}
