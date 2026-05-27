<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    // LANGSUNG METHOD TANPA CONSTRUCTOR

    public function index()
    {
        $destinations = Destination::where('agent_id', Auth::guard('agent')->id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('agen.destinations.index', compact('destinations'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('agen.destinations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'images' => 'required|array|min:3',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $destination = Destination::create([
            'agent_id' => Auth::guard('agent')->id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'location' => $request->location,
            'province' => $request->province,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'active'
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('destinations', 'public');
                $destination->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('agen.destinations.index')
            ->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $destination = Destination::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        $categories = Category::all();
        return view('agen.destinations.edit', compact('destination', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
        ]);

        $destination->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'location' => $request->location,
            'province' => $request->province,
            'city' => $request->city,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('agen.destinations.index')
            ->with('success', 'Destinasi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $destination = Destination::where('agent_id', Auth::guard('agent')->id())
            ->findOrFail($id);
        
        foreach ($destination->images as $image) {
            \Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        
        $destination->delete();

        return redirect()->route('agen.destinations.index')
            ->with('success', 'Destinasi berhasil dihapus!');
    }
}