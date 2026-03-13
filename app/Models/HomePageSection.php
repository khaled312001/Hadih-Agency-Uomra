<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomePageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title_ar',
        'title_en',
        'subtitle_ar',
        'subtitle_en',
        'content_ar',
        'content_en',
        'image',
        'video_url',
        'button_text_ar',
        'button_text_en',
        'button_link',
        'order',
        'is_active',
    ];

    protected $casts = [
        'content_ar' => 'array',
        'content_en' => 'array',
        'is_active' => 'boolean',
    ];
}
