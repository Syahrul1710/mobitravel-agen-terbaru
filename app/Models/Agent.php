<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    protected $table = 'agents';
    
    protected $fillable = [
        'nik', 'agency_name', 'email', 'password', 'phone', 'whatsapp',
        'city', 'province', 'address', 'description', 'ktp_photo', 'status'
    ];
    
    protected $hidden = ['password'];
}