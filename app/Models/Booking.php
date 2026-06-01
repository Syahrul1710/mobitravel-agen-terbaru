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
        'booking_type',           // ← TAMBAHKAN INI
        'user_id',
        'agent_id',
        'tour_package_id',
        'vehicle_id',             // ← TAMBAHKAN INI
        'customer_name',
        'customer_email',
        'customer_phone',
        'participants',
        'travel_date',
        'pickup_location',        // ← TAMBAHKAN INI
        'dropoff_location',       // ← TAMBAHKAN INI
        'with_driver',            // ← TAMBAHKAN INI
        'total_price',
        'sub_total',              // ← TAMBAHKAN INI
        'payment_status',
        'payment_method',
        'midtrans_order_id',
        'special_requests',
        'payment_proof',
        'paid_at',
        'expired_at',
        'origin_city',            // ← TAMBAHKAN INI
        'destination',            // ← TAMBAHKAN INI
        'departure_date',         // ← TAMBAHKAN INI
        'passengers',             // ← TAMBAHKAN INI
        'platform_fee',           // ← TAMBAHKAN INI
        'total_amount',           // ← TAMBAHKAN INI
        'status'                  // ← TAMBAHKAN INI
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

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