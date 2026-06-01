<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // List kendaraan
    public function index(Request $request)
    {
        $query = Vehicle::with('agent')
            ->where('status', 'available');

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by minimum capacity
        if ($request->has('capacity') && $request->capacity) {
            $query->where('capacity', '>=', $request->capacity);
        }

        // Filter by with/without driver
        if ($request->has('with_driver')) {
            // Tidak perlu filter, harga akan ditentukan di Flutter
        }

        $vehicles = $query->orderBy('price_with_driver')->paginate(15);

        // Parse routes JSON
        foreach ($vehicles as $vehicle) {
            $vehicle->routes = $vehicle->routes ? json_decode($vehicle->routes, true) : [];
            if ($vehicle->photo) {
                $vehicle->photo_url = asset('storage/' . $vehicle->photo);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $vehicles
        ]);
    }

    // Detail kendaraan
    public function show($id)
    {
        $vehicle = Vehicle::with('agent')->find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan'
            ], 404);
        }

        $vehicle->routes = $vehicle->routes ? json_decode($vehicle->routes, true) : [];
        if ($vehicle->photo) {
            $vehicle->photo_url = asset('storage/' . $vehicle->photo);
        }

        return response()->json([
            'success' => true,
            'data' => $vehicle
        ]);
    }
}