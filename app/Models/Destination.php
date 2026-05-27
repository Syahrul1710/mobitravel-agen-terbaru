<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destinations';
    
    protected $fillable = [
        'agent_id', 'category_id', 'name', 'slug', 'description',
        'location', 'province', 'city', 'latitude', 'longitude',
        'view_count', 'status'
    ];

    // Relasi ke agen
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke gambar
    public function images()
    {
        return $this->hasMany(DestinationImage::class);
    }

    // Relasi ke paket wisata
    public function tourPackages()
    {
        return $this->hasMany(TourPackage::class);
    }
}