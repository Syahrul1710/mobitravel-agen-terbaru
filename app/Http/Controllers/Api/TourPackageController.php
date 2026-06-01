<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class TourPackageController extends Controller
{
    // List paket wisata
    public function index(Request $request)
    {
        $query = TourPackage::with(['destination', 'agent', 'images'])
            ->where('status', 'available');

        // Filter by destination
        if ($request->has('destination_id') && $request->destination_id) {
            $query->where('destination_id', $request->destination_id);
        }

        // Filter by min price
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filter by max price
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by duration
        if ($request->has('duration') && $request->duration) {
            $query->where('duration', 'like', "%{$request->duration}%");
        }

        $packages = $query->orderBy('price')->paginate(15);

        // Format image URLs
        foreach ($packages as $package) {
            foreach ($package->images as $image) {
                $image->image_url = asset('storage/' . $image->image_path);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    // Detail paket wisata
    public function show($id)
    {
        $package = TourPackage::with(['destination', 'agent', 'images', 'itineraries'])
            ->find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Paket wisata tidak ditemukan'
            ], 404);
        }

        // Format image URLs
        foreach ($package->images as $image) {
            $image->image_url = asset('storage/' . $image->image_path);
        }

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    // Cek ketersediaan kuota
    public function checkAvailability($id)
    {
        $package = TourPackage::find($id);

        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Paket tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'available' => $package->isAvailable(),
                'quota' => $package->quota,
                'status' => $package->status
            ]
        ]);
    }
}