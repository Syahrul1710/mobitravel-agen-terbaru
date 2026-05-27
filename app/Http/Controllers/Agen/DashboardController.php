<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $agent = Auth::guard('agent')->user();
        $agentId = $agent->id;
        
        // Statistik
        $totalDestinasi = Destination::where('agent_id', $agentId)->count();
        $totalPackages = TourPackage::where('agent_id', $agentId)->count();
        $totalVehicles = Vehicle::where('agent_id', $agentId)->count();
        
        // Hitung total rute dari semua kendaraan
        $totalRoutes = 0;
        $vehicles = Vehicle::where('agent_id', $agentId)->get();
        foreach ($vehicles as $vehicle) {
            $routes = is_string($vehicle->routes) ? json_decode($vehicle->routes, true) : ($vehicle->routes ?? []);
            $totalRoutes += count($routes);
        }
        
        $totalBookings = Booking::where('agent_id', $agentId)->count();
        $pendingPayments = Booking::where('agent_id', $agentId)->where('payment_status', 'pending')->count();
        $totalRevenue = Booking::where('agent_id', $agentId)->where('payment_status', 'paid')->sum('total_price');
        $averageRating = 4.8;
        
        // Peraturan & Ketentuan Agen
        $rules = [
            'Pastikan semua data kendaraan dan rute terisi dengan benar.',
            'Harga yang ditampilkan sudah termasuk pajak dan biaya admin.',
            'Pembayaran dari customer akan masuk ke rekening admin dan akan ditransfer setelah perjalanan selesai.',
            'Agen wajib memberikan pelayanan terbaik kepada customer.',
            'Jika terjadi pembatalan dari customer, dana akan dikembalikan sesuai kebijakan refund.',
            'Agen harus merespon permintaan customer maksimal 2x24 jam.',
            'Dilarang melakukan tindakan yang merugikan customer atau platform.',
            'Setiap pelanggaran akan dikenakan sanksi berupa suspend atau penutupan akun.'
        ];
        
        return view('agen.dashboard', compact(
            'agent',
            'totalDestinasi',
            'totalPackages',
            'totalVehicles',
            'totalRoutes',
            'totalBookings',
            'pendingPayments',
            'totalRevenue',
            'averageRating',
            'rules'
        ));
    }
}