<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'eyebrow',
        'hero_title',
        'hero_subtitle',
        'excerpt',
        'content',
        'template',
        'featured_image',
        'cta_label',
        'cta_url',
        'show_in_nav',
        'sort_order',
        'status',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'show_in_nav' => 'boolean',
    ];

    public function getFeaturedImageUrlAttribute(): string
    {
        if (! $this->featured_image) {
            return asset('images/zala-hero.png');
        }

        if (str_starts_with($this->featured_image, 'images/')) {
            return asset($this->featured_image);
        }

        return asset('storage/'.$this->featured_image);
    }
}
