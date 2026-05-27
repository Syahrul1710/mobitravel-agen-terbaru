<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // Daftar semua user
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status);
        }
        
        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $blockedUsers = User::where('is_active', false)->count();
        
        return view('admin.users.index', compact('users', 'totalUsers', 'activeUsers', 'blockedUsers'));
    }
    
    // Detail user beserta riwayat booking
    public function show($id)
    {
        $user = User::with('bookings')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    
    // Blokir user
    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = false;
        $user->save();
        
        return redirect()->back()->with('success', "User {$user->name} telah diblokir.");
    }
    
    // Aktifkan user
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = true;
        $user->save();
        
        return redirect()->back()->with('success', "User {$user->name} telah diaktifkan.");
    }
    
    // Hapus user permanent
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', "User {$userName} telah dihapus.");
    }
}