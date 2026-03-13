<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'umrah_package_id',
        'beneficiary_name',
        'beneficiary_phone',
        'whatsapp_country_code',
        'whatsapp_phone',
        'beneficiary_address',
        'beneficiary_type',
        'beneficiary_details',
        'total_amount',
        'currency',
        'status',
        'notes',
        'assigned_at',
        'completed_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function umrahPackage()
    {
        return $this->belongsTo(UmrahPackage::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }


    // Methods
    public function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
