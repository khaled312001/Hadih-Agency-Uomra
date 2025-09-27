<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'title',
        'description',
        'video_path',
        'thumbnail',
        'duration',
        'file_size',
        'ritual_type',
        'is_approved',
        'admin_notes',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeByRitualType($query, $type)
    {
        return $query->where('ritual_type', $type);
    }
}
