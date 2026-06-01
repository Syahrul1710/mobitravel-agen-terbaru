<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'booking_type' => 'required|in:package,vehicle',
                'item_id' => 'required|integer',
                'travel_date' => 'required|date',
                'participants' => 'required|integer|min:1',
                'pickup_location' => 'required_if:booking_type,vehicle|string',
                'dropoff_location' => 'required_if:booking_type,vehicle|string',
                'with_driver' => 'boolean',
            ]);

            $user = $request->user();
            $bookingCode = 'MBT' . strtoupper(uniqid()) . date('ymd');

            if ($request->booking_type == 'vehicle') {
                $vehicle = Vehicle::find($request->item_id);
                
                if (!$vehicle || $vehicle->status != 'available') {
                    return response()->json(['success' => false, 'message' => 'Kendaraan tidak tersedia'], 400);
                }

                $price = $request->with_driver ? $vehicle->price_with_driver : $vehicle->price_without_driver;
                $totalPrice = $price;

                $booking = Booking::create([
    'booking_code' => $bookingCode,
    'booking_type' => 'package',
    'user_id' => $user->id,
    'agent_id' => $package->agent_id,
    'tour_package_id' => $package->id,
    'customer_name' => $user->name,
    'customer_email' => $user->email,
    'customer_phone' => $user->phone ?? '',
    'participants' => $request->participants,
    'travel_date' => $request->travel_date,
    'total_price' => $totalPrice,
    'sub_total' => $totalPrice,
    'payment_status' => 'pending',
    'expired_at' => now()->addDay(1),
    'platform_fee' => 0,
    'total_amount' => $totalPrice,  // ← juga tidak ada, hapus kalau error
    'status' => 'pending'
]);

                $vehicle->update(['status' => 'booked']);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Booking kendaraan berhasil',
                    'data' => $booking
                ], 201);
            }

            if ($request->booking_type == 'package') {
                $package = TourPackage::find($request->item_id);
                
                if (!$package || $package->status != 'available') {
                    return response()->json(['success' => false, 'message' => 'Paket wisata tidak tersedia'], 400);
                }

                $totalPrice = $package->price * $request->participants;

                $booking = Booking::create([
                    'booking_code' => $bookingCode,
                    'booking_type' => 'package',
                    'user_id' => $user->id,
                    'agent_id' => $package->agent_id,
                    'tour_package_id' => $package->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? '',
                    'participants' => $request->participants,
                    'travel_date' => $request->travel_date,
                    'total_price' => $totalPrice,
                    'sub_total' => $totalPrice,
                    'payment_status' => 'pending',
                    'expired_at' => now()->addDay(1),
                    'departure_date' => $request->travel_date,
                    'passengers' => $request->participants,
                    'platform_fee' => 0,
                    'total_amount' => $totalPrice,
                    'status' => 'pending'
                ]);

                $package->decrement('quota', $request->participants);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Booking paket wisata berhasil',
                    'data' => $booking
                ], 201);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function myBookings(Request $request)
    {
        $bookings = Booking::where('user_id', $request->user()->id)
            ->with(['tourPackage', 'vehicle', 'agent'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->with(['tourPackage', 'vehicle', 'agent'])
            ->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan atau sudah dibayar'
            ], 404);
        }

        $booking->update(['payment_status' => 'expired']);

        if ($booking->booking_type == 'package' && $booking->tourPackage) {
            $booking->tourPackage->increment('quota', $booking->participants);
        } elseif ($booking->booking_type == 'vehicle' && $booking->vehicle) {
            $booking->vehicle->update(['status' => 'available']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibatalkan'
        ]);
    }
}