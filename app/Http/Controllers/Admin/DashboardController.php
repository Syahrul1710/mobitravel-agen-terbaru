<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAgents = Agent::count();
        $pendingAgents = Agent::where('status', 'pending')->count();
        $activeAgents = Agent::where('status', 'active')->count();
        
        // Sementara untuk sementara, nanti diisi
        $totalBookings = 0;
        $totalPackages = 0;
        
        return view('admin.dashboard', compact(
            'totalAgents', 'pendingAgents', 'activeAgents',
            'totalBookings', 'totalPackages'
        ));
    }
}