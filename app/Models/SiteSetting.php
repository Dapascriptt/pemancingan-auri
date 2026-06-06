<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'hero_eyebrow',
        'hero_title',
        'hero_subtitle',
        'hero_cta_text',
        'hero_cta_link',
        'hero_secondary_text',
        'hero_secondary_link',
        'hero_image',
        'about_title',
        'about_description',
        'about_image',
        'highlights',
    ];

    protected $casts = [
        'highlights' => 'array',
    ];
}
