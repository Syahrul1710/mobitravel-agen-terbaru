<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';

    protected $fillable = [
        'agent_id', 'name', 'type', 'plate_number', 'capacity',
        'facilities', 'photo', 'price_with_driver', 'price_without_driver', 
        'status', 'routes'
    ];

    protected $casts = [
        'routes' => 'array',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function travelRequests()
    {
        return $this->hasMany(TravelRequest::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function getRoutesListAttribute()
    {
        return $this->routes ?? [];
    }
}