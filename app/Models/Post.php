<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'cover_image',
        'status',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getCoverImageUrlAttribute(): string
    {
        if (! $this->cover_image) {
            return asset('images/zala-hero.png');
        }

        if (str_starts_with($this->cover_image, 'images/')) {
            return asset($this->cover_image);
        }

        return asset('storage/'.$this->cover_image);
    }
}
