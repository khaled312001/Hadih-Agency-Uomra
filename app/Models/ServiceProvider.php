<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'id_number',
        'address',
        'qualification',
        'experience',
        'certificates',
        'profile_image',
        'status',
        'rating',
        'total_orders',
        'is_available',
    ];

    protected $casts = [
        'certificates' => 'array',
        'rating' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}