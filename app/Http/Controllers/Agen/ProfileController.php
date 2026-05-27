<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Tampilkan profil
    public function index()
    {
        $agent = Auth::guard('agent')->user();
        return view('agen.profile.index', compact('agent'));
    }

    // Update profil
    public function update(Request $request)
    {
        $agent = Auth::guard('agent')->user();

        $request->validate([
            'agency_name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone' => 'required|string|max:15',
            'whatsapp' => 'required|string|max:15',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'address' => 'required|string',
            'description' => 'required|string',
        ]);

        $agent->update([
            'agency_name' => $request->agency_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'city' => $request->city,
            'province' => $request->province,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return redirect()->route('agen.profile.index')
            ->with('success', 'Profil berhasil diupdate!');
    }

    // Ganti password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $agent = Auth::guard('agent')->user();

        if (!Hash::check($request->current_password, $agent->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $agent->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('agen.profile.index')
            ->with('success', 'Password berhasil diubah!');
    }

    // Upload foto profil/logo
   public function uploadLogo(Request $request)
    {
    // Validasi
    $request->validate([
        'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $agent = Auth::guard('agent')->user();

    // Hapus logo lama jika ada
    if ($agent->logo && Storage::disk('public')->exists($agent->logo)) {
        Storage::disk('public')->delete($agent->logo);
    }

    // Upload file baru
    $file = $request->file('logo');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('agent-logos', $filename, 'public');

    // Update database
    $agent->logo = $path;
    $agent->save();

    // Debug: cek apakah tersimpan
    \Log::info('Logo saved: ' . $path);
    \Log::info('Agent ID: ' . $agent->id);
    \Log::info('Agent logo after save: ' . $agent->logo);

    return redirect()->route('agen.profile.index')
        ->with('success', 'Logo berhasil diupload!');
    }
}