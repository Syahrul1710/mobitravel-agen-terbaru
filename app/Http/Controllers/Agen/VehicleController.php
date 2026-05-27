<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('agent_id', Auth::guard('agent')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('agen.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('agen.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'plate_number' => 'required|string|unique:vehicles,plate_number',
            'capacity' => 'required|integer|min:1',
            'price_with_driver' => 'required|integer|min:0',
            'price_without_driver' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('photo', 'routes');
        $data['agent_id'] = Auth::guard('agent')->id();

        // Simpan rute (tanpa harga)
        if ($request->has('routes')) {
            $routes = [];
            foreach ($request->routes as $route) {
                if (!empty($route['pickup']) && !empty($route['dropoff'])) {
                    $routes[] = [
                        'id' => uniqid(),
                        'pickup' => $route['pickup'],
                        'dropoff' => $route['dropoff'],
                    ];
                }
            }
            if (count($routes) > 0) {
                $data['routes'] = json_encode($routes);
            }
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('agen.vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        return view('agen.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $id,
            'capacity' => 'required|integer|min:1',
            'price_with_driver' => 'required|integer|min:0',
            'price_without_driver' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('photo', 'routes');

        // Update rute
        if ($request->has('routes')) {
            $routes = [];
            foreach ($request->routes as $route) {
                if (!empty($route['pickup']) && !empty($route['dropoff'])) {
                    $routes[] = [
                        'id' => $route['id'] ?? uniqid(),
                        'pickup' => $route['pickup'],
                        'dropoff' => $route['dropoff'],
                    ];
                }
            }
            if (count($routes) > 0) {
                $data['routes'] = json_encode($routes);
            }
        }

        if ($request->hasFile('photo')) {
            if ($vehicle->photo) {
                Storage::disk('public')->delete($vehicle->photo);
            }
            $data['photo'] = $request->file('photo')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('agen.vehicles.index')
            ->with('success', 'Kendaraan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        
        if ($vehicle->photo) {
            Storage::disk('public')->delete($vehicle->photo);
        }
        
        $vehicle->delete();

        return redirect()->route('agen.vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $vehicle = Vehicle::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        
        $vehicle->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status kendaraan diupdate!');
    }
}