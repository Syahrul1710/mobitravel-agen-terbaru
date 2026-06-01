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
                'booking_type'     => 'required|in:package,vehicle',
                'item_id'          => 'required|integer',
                'travel_date'      => 'required|date',
                'participants'     => 'required|integer|min:1',
                'pickup_location'  => 'required_if:booking_type,vehicle|string',
                'dropoff_location' => 'required_if:booking_type,vehicle|string',
                'with_driver'      => 'boolean',
            ]);

            $user        = $request->user();
            $bookingCode = 'MBT' . strtoupper(Str::random(8)) . date('ymd');

            // ── VEHICLE ──────────────────────────────────────────────────────
            if ($request->booking_type === 'vehicle') {
                $vehicle = Vehicle::find($request->item_id);

                if (!$vehicle || $vehicle->status !== 'available') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kendaraan tidak tersedia',
                    ], 400);
                }

                $price      = $request->boolean('with_driver')
                    ? $vehicle->price_with_driver
                    : $vehicle->price_without_driver;
                $totalPrice = $price;

                $booking = Booking::create([
                    'booking_code'    => $bookingCode,
                    'booking_type'    => 'vehicle',          // ← fix: was 'package'
                    'user_id'         => $user->id,
                    'vehicle_id'      => $vehicle->id,       // ← fix: was $package
                    'customer_name'   => $user->name,
                    'customer_email'  => $user->email,
                    'customer_phone'  => $user->phone ?? '',
                    'participants'    => $request->participants,
                    'travel_date'     => $request->travel_date,
                    'departure_date'  => $request->travel_date,
                    'passengers'      => $request->participants,
                    'total_price'     => $totalPrice,
                    'sub_total'       => $totalPrice,
                    'platform_fee'    => 0,
                    'total_amount'    => $totalPrice,
                    'payment_status'  => 'pending',
                    'status'          => 'pending',
                    'expired_at'      => now()->addDay(),
                    'qr_code'         => $this->_generateQrString($bookingCode, $totalPrice),
                    'payment_code'    => strtoupper(Str::random(6)),
                ]);

                $vehicle->update(['status' => 'booked']);

                return response()->json([
                    'success' => true,
                    'message' => 'Booking kendaraan berhasil',
                    'data'    => $booking,
                ], 201);
            }

            // ── PACKAGE ──────────────────────────────────────────────────────
            if ($request->booking_type === 'package') {
                $package = TourPackage::find($request->item_id);

                if (!$package || $package->status !== 'available') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Paket wisata tidak tersedia',
                    ], 400);
                }

                $totalPrice = $package->price * $request->participants;

                $booking = Booking::create([
                    'booking_code'   => $bookingCode,
                    'booking_type'   => 'package',
                    'user_id'        => $user->id,
                    'agent_id'       => $package->agent_id,
                    'tour_package_id'=> $package->id,
                    'customer_name'  => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? '',
                    'participants'   => $request->participants,
                    'travel_date'    => $request->travel_date,
                    'departure_date' => $request->travel_date,
                    'passengers'     => $request->participants,
                    'total_price'    => $totalPrice,
                    'sub_total'      => $totalPrice,
                    'platform_fee'   => 0,
                    'total_amount'   => $totalPrice,
                    'payment_status' => 'pending',
                    'status'         => 'pending',
                    'expired_at'     => now()->addDay(),
                    'qr_code'        => $this->_generateQrString($bookingCode, $totalPrice),
                    'payment_code'   => strtoupper(Str::random(6)),
                ]);

                $package->decrement('quota', $request->participants);

                return response()->json([
                    'success' => true,
                    'message' => 'Booking paket wisata berhasil',
                    'data'    => $booking,
                ], 201);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * GET /api/bookings/{bookingCode}/payment
     * Mengembalikan data QRIS untuk ditampilkan di Flutter
     */
    public function getPayment($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan',
            ], 404);
        }

        if ($booking->payment_status === 'paid') {
            return response()->json([
                'success' => true,
                'data'    => [
                    'already_paid' => true,
                    'booking_code' => $booking->booking_code,
                ],
            ]);
        }

        // Cek expired
        if (now()->isAfter($booking->expired_at)) {
            $booking->update(['payment_status' => 'expired', 'status' => 'cancelled']);
            return response()->json([
                'success' => false,
                'message' => 'Waktu pembayaran sudah habis',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'booking_code'   => $booking->booking_code,
                'payment_code'   => $booking->payment_code,
                'qr_code'        => $booking->qr_code,       // string untuk QR
                'total_amount'   => $booking->total_amount,
                'expired_at'     => $booking->expired_at,
                'payment_status' => $booking->payment_status,
                'already_paid'   => false,
            ],
        ]);
    }

    /**
     * POST /api/bookings/{bookingCode}/confirm-payment
     * Simulasi konfirmasi pembayaran (untuk dev/testing tanpa payment gateway)
     */
    public function confirmPayment($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
            ->where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan atau sudah dibayar',
            ], 404);
        }

        if (now()->isAfter($booking->expired_at)) {
            $booking->update(['payment_status' => 'expired', 'status' => 'cancelled']);
            return response()->json([
                'success' => false,
                'message' => 'Waktu pembayaran sudah habis',
            ], 400);
        }

        $booking->update([
            'payment_status' => 'paid',
            'status'         => 'active',
            'paid_at'        => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi',
            'data'    => $booking,
        ]);
    }

    public function myBookings(Request $request)
    {
        $bookings = Booking::where('user_id', $request->user()->id)
            ->with(['tourPackage', 'vehicle', 'agent'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $bookings,
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
                'message' => 'Booking tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $booking,
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
                'message' => 'Booking tidak ditemukan atau sudah dibayar',
            ], 404);
        }

        $booking->update([
            'payment_status' => 'expired',
            'status'         => 'cancelled',
        ]);

        if ($booking->booking_type === 'package' && $booking->tourPackage) {
            $booking->tourPackage->increment('quota', $booking->participants);
        } elseif ($booking->booking_type === 'vehicle' && $booking->vehicle) {
            $booking->vehicle->update(['status' => 'available']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibatalkan',
        ]);
    }

    // ── Private Helpers ───────────────────────────────────────────────────────

    /**
     * Generate string data untuk QR code.
     * Format mengikuti QRIS standar (simplified).
     * Di production, ganti dengan integrasi Midtrans / Xendit / dll.
     */
    private function _generateQrString(string $bookingCode, int $amount): string
    {
        // Format QRIS sederhana — bisa diganti dengan payload QRIS real
        return implode('|', [
            'MOBITRAVEL',
            $bookingCode,
            $amount,
            now()->addDay()->format('YmdHis'),
        ]);
    }
}