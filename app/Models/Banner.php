<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'kicker', 'subtitle', 'image', 'category_filter',
        'button_text', 'button_link', 'order', 'is_active', 'type'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
