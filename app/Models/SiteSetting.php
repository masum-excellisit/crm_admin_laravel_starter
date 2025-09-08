<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'header_logo',
        'footer_logo',
        'footer_description',
        'opening_day',
        'opening_time',
        'phone_number',
        'address',
        'social_links',
        'newsletter_title',
        'newsletter_subtitle'
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
