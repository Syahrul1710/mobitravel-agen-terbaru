<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\RoutePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutePackageController extends Controller
{
    public function index()
    {
        $routes = RoutePackage::where('agent_id', Auth::guard('agent')->id())
            ->orderBy('pickup_city')
            ->paginate(10);
        return view('agen.route-packages.index', compact('routes'));
    }

    public function create()
    {
        return view('agen.route-packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_city' => 'required|string|max:255',
            'dropoff_city' => 'required|string|max:255',
            'price_with_driver' => 'required|integer|min:0',
            'price_without_driver' => 'required|integer|min:0',
        ]);

        RoutePackage::create([
            'agent_id' => Auth::guard('agent')->id(),
            'pickup_city' => $request->pickup_city,
            'dropoff_city' => $request->dropoff_city,
            'price_with_driver' => $request->price_with_driver,
            'price_without_driver' => $request->price_without_driver,
            'estimated_hours' => $request->estimated_hours,
            'distance_km' => $request->distance_km,
        ]);

        return redirect()->route('agen.route-packages.index')
            ->with('success', 'Rute paket berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $route = RoutePackage::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        return view('agen.route-packages.edit', compact('route'));
    }

    public function update(Request $request, $id)
    {
        $route = RoutePackage::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);

        $request->validate([
            'pickup_city' => 'required|string|max:255',
            'dropoff_city' => 'required|string|max:255',
            'price_with_driver' => 'required|integer|min:0',
            'price_without_driver' => 'required|integer|min:0',
        ]);

        $route->update($request->all());

        return redirect()->route('agen.route-packages.index')
            ->with('success', 'Rute paket berhasil diupdate!');
    }

    public function destroy($id)
    {
        $route = RoutePackage::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        $route->delete();

        return redirect()->route('agen.route-packages.index')
            ->with('success', 'Rute paket berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $route = RoutePackage::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        $route->update(['is_active' => !$route->is_active]);

        return redirect()->back()->with('success', 'Status rute diubah!');
    }
}