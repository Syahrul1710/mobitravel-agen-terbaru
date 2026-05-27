<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackageImage extends Model
{
    use HasFactory;

    protected $table = 'tour_package_images';
    
    protected $fillable = [
        'tour_package_id',
        'image_path',
        'sort_order'
    ];

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }
}