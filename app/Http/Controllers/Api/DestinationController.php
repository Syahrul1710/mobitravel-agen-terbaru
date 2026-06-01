<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    // List semua destinasi
    public function index(Request $request)
    {
        $query = Destination::with(['category', 'agent', 'images'])
            ->where('status', 'active');

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by province
        if ($request->has('province') && $request->province) {
            $query->where('province', 'like', "%{$request->province}%");
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $destinations = $query->orderBy('name')->paginate(15);

        // Format image URLs
        foreach ($destinations as $dest) {
            foreach ($dest->images as $image) {
                $image->image_url = asset('storage/' . $image->image_path);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $destinations
        ]);
    }

    // Detail destinasi
    public function show($id)
    {
        $destination = Destination::with(['category', 'agent', 'images', 'tourPackages'])
            ->where('status', 'active')
            ->find($id);

        if (!$destination) {
            return response()->json([
                'success' => false,
                'message' => 'Destinasi tidak ditemukan'
            ], 404);
        }

        // Format image URLs
        foreach ($destination->images as $image) {
            $image->image_url = asset('storage/' . $image->image_path);
        }

        // Increment view count
        $destination->increment('view_count');

        return response()->json([
            'success' => true,
            'data' => $destination
        ]);
    }

    // List kategori
    public function categories()
    {
        $categories = \App\Models\Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}