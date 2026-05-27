<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id', 'pickup_city', 'dropoff_city', 
        'price_with_driver', 'price_without_driver', 
        'estimated_hours', 'distance_km', 'is_active'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function getRouteNameAttribute()
    {
        return $this->pickup_city . ' → ' . $this->dropoff_city;
    }
}