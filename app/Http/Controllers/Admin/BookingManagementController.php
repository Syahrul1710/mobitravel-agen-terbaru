<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    // Daftar semua pemesanan
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'agent', 'tourPackage']);
        
        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search by booking code or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $totalBookings = Booking::count();
        $pendingPayments = Booking::where('payment_status', 'pending')->count();
        $paidBookings = Booking::where('payment_status', 'paid')->count();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
        
        return view('admin.bookings.index', compact(
            'bookings', 'totalBookings', 'pendingPayments', 
            'paidBookings', 'totalRevenue'
        ));
    }
    
    // Detail pemesanan
    public function show($id)
    {
        $booking = Booking::with(['user', 'agent', 'tourPackage'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }
    
    // Update status pembayaran
    public function updatePaymentStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->payment_status = $request->payment_status;
        
        if ($request->payment_status == 'paid') {
            $booking->paid_at = now();
        }
        
        $booking->save();
        
        return redirect()->back()->with('success', "Status pembayaran booking {$booking->booking_code} diupdate.");
    }
    
    // Batalkan pemesanan
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->payment_status = 'expired';
        $booking->save();
        
        return redirect()->back()->with('success', "Booking {$booking->booking_code} telah dibatalkan.");
    }
    
    // Hapus pemesanan
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $bookingCode = $booking->booking_code;
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')->with('success', "Booking {$bookingCode} telah dihapus.");
    }
}