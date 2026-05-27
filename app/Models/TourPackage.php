<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $table = 'tour_packages';
    
    protected $fillable = [
        'agent_id',
        'destination_id',
        'name',
        'slug',
        'description',
        'duration',
        'price',
        'quota',
        'status'
    ];

    // Relasi ke agen
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    // Relasi ke destinasi
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // Relasi ke gambar
    public function images()
    {
        return $this->hasMany(TourPackageImage::class);
    }

    // Relasi ke booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Cek apakah kuota masih tersedia
    public function isAvailable()
    {
        return $this->status === 'available' && $this->quota > 0;
    }

    // Kurangi kuota setelah booking
    public function reduceQuota($jumlah = 1)
    {
        $this->quota -= $jumlah;
        if ($this->quota <= 0) {
            $this->status = 'sold_out';
        }
        $this->save();
    }
}