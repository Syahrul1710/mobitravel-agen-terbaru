<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Halaman Register
    public function showRegister()
    {
        return view('agen.auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:agents,nik',
            'agency_name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|string|max:15',
            'whatsapp' => 'required|string|max:15',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'address' => 'required|string',
            'description' => 'required|string',
            'ktp_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload KTP
        $ktpPath = $request->file('ktp_photo')->store('ktp_photos', 'public');

        // Buat Agen
        $agent = Agent::create([
            'nik' => $request->nik,
            'agency_name' => $request->agency_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'city' => $request->city,
            'province' => $request->province,
            'address' => $request->address,
            'description' => $request->description,
            'ktp_photo' => $ktpPath,
            'status' => 'pending', // Menunggu verifikasi admin
        ]);

        return redirect()->route('agen.login')->with('success', 'Pendaftaran berhasil! Silakan tunggu verifikasi dari admin.');
    }

    // Halaman Login
    public function showLogin()
    {
        return view('agen.auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $agent = Agent::where('email', $request->email)->first();

        if (!$agent || !Hash::check($request->password, $agent->password)) {
            return back()->with('error', 'Email atau password salah!');
        }

        if ($agent->status == 'pending') {
            return back()->with('error', 'Akun Anda sedang menunggu verifikasi admin.');
        }

        if ($agent->status == 'suspended') {
            return back()->with('error', 'Akun Anda telah ditangguhkan. Hubungi admin.');
        }

        Auth::guard('agent')->login($agent);

        return redirect()->route('agen.dashboard');
    }

    // Logout
    public function logout()
    {
        Auth::guard('agent')->logout();
        return redirect()->route('agen.login');
    }
}