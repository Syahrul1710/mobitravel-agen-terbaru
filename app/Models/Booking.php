<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    
    protected $fillable = [
        'booking_code',
        'user_id',
        'agent_id',
        'tour_package_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'participants',
        'travel_date',
        'total_price',
        'payment_status',
        'payment_method',
        'midtrans_order_id',
        'special_requests',
        'payment_proof',
        'paid_at',
        'expired_at'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}