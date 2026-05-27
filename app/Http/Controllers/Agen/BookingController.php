<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
    $query = Booking::where('agent_id', Auth::guard('agent')->id())
        ->with(['tourPackage', 'vehicle']);

    // Filter by type (package / vehicle)
    if ($request->has('type') && $request->type != '') {
        $query->where('booking_type', $request->type);
    }

    // Filter by payment status
    if ($request->has('status') && $request->status != '') {
        $query->where('payment_status', $request->status);
    }

    // Search
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('booking_code', 'like', "%{$search}%")
              ->orWhere('customer_name', 'like', "%{$search}%")
              ->orWhere('customer_email', 'like', "%{$search}%");
        });
    }

    $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

    // Stats
    $totalBookings = Booking::where('agent_id', Auth::guard('agent')->id())->count();
    $pendingPayments = Booking::where('agent_id', Auth::guard('agent')->id())->where('payment_status', 'pending')->count();
    $paidBookings = Booking::where('agent_id', Auth::guard('agent')->id())->where('payment_status', 'paid')->count();
    $totalRevenue = Booking::where('agent_id', Auth::guard('agent')->id())->where('payment_status', 'paid')->sum('total_price');

    return view('agen.bookings.index', compact('bookings', 'totalBookings', 'pendingPayments', 'paidBookings', 'totalRevenue'));
    }

    public function show($id)
    {
        $booking = Booking::where('agent_id', Auth::guard('agent')->id())
            ->with(['tourPackage', 'vehicle'])
            ->findOrFail($id);
        
        return view('agen.bookings.show', compact('booking'));
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $booking = Booking::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);

        $request->validate([
            'payment_status' => 'required|in:pending,paid,expired'
        ]);

        $booking->payment_status = $request->payment_status;
        
        if ($request->payment_status == 'paid') {
            $booking->paid_at = now();
        }
        
        $booking->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate.');
    }

    public function cancel($id)
    {
        $booking = Booking::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);

        $booking->payment_status = 'expired';
        $booking->save();

        return redirect()->back()->with('success', 'Pemesanan telah dibatalkan.');
    }
}