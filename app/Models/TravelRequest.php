<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'agent_id', 'vehicle_id', 'pickup_location', 'dropoff_location',
        'travel_date', 'pickup_time', 'passengers', 'need_driver', 'suggested_price',
        'final_price', 'status', 'notes', 'approved_at', 'confirmed_at'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'pickup_time' => 'datetime',
        'approved_at' => 'datetime',
        'confirmed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}