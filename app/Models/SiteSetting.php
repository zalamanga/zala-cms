<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'tagline',
        'description',
        'contact_email',
        'contact_phone',
        'address',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'default_meta_title',
        'default_meta_description',
    ];

    public static function current(): self
    {
        return self::query()->firstOrCreate([], [
            'site_name' => 'ZalaCMS',
            'tagline' => 'Custom CMS Company Profile Builder',
            'description' => 'Laravel CMS untuk company profile, blog/news, contact inbox, SEO, dan audit log.',
            'contact_email' => 'hello@zala.test',
            'contact_phone' => '+62 812 0000 0000',
            'address' => 'Jakarta, Indonesia',
            'default_meta_title' => 'ZalaCMS - Custom CMS Company Profile',
            'default_meta_description' => 'Custom CMS company profile berbasis Laravel, Blade, MySQL, dan Tailwind.',
        ]);
    }
}
