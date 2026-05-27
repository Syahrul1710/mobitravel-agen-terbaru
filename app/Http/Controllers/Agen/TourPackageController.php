<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TourPackageController extends Controller
{
    // List paket wisata
    public function index()
    {
        $packages = TourPackage::where('agent_id', Auth::guard('agent')->id())
            ->with('destination')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('agen.tour-packages.index', compact('packages'));
    }

    // Form tambah paket
    public function create()
    {
        $destinations = Destination::where('agent_id', Auth::guard('agent')->id())
            ->where('status', 'active')
            ->get();
        return view('agen.tour-packages.create', compact('destinations'));
    }

    // Simpan paket
    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'quota' => 'required|integer|min:1',
            'images' => 'required|array|min:2',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $package = TourPackage::create([
            'agent_id' => Auth::guard('agent')->id(),
            'destination_id' => $request->destination_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'duration' => $request->duration,
            'price' => $request->price,
            'quota' => $request->quota,
            'status' => 'available'
        ]);

        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('tour-packages', 'public');
                $package->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('agen.tour-packages.index')
            ->with('success', 'Paket wisata berhasil ditambahkan!');
    }

    // Edit paket
    public function edit($id)
    {
        $package = TourPackage::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        $destinations = Destination::where('agent_id', Auth::guard('agent')->id())
            ->where('status', 'active')
            ->get();
        return view('agen.tour-packages.edit', compact('package', 'destinations'));
    }

    // Update paket
    public function update(Request $request, $id)
    {
        $package = TourPackage::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);

        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'quota' => 'required|integer|min:1',
        ]);

        $package->update([
            'destination_id' => $request->destination_id,
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'price' => $request->price,
            'quota' => $request->quota,
        ]);

        // Update status otomatis jika kuota habis
        if ($package->quota <= 0) {
            $package->update(['status' => 'sold_out']);
        }

        return redirect()->route('agen.tour-packages.index')
            ->with('success', 'Paket wisata berhasil diupdate!');
    }

    // Hapus paket
    public function destroy($id)
    {
        $package = TourPackage::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        
        foreach ($package->images as $image) {
            \Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        $package->delete();

        return redirect()->route('agen.tour-packages.index')
            ->with('success', 'Paket wisata berhasil dihapus!');
    }
}