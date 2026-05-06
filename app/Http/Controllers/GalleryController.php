<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display the gallery page with all active gallery items
     */
    public function index()
    {
        $galleryItems = Gallery::active()
            ->ordered()
            ->get();

        return view('gallery', compact('galleryItems'));
    }

    /**
     * Get gallery items by category (for AJAX requests)
     */
    public function getByCategory($category)
    {
        $galleryItems = Gallery::active()
            ->byCategory($category)
            ->ordered()
            ->get();

        return response()->json($galleryItems);
    }

    /**
     * Get featured gallery items (for homepage or featured section)
     */
    public function getFeatured()
    {
        $featuredItems = Gallery::active()
            ->featured()
            ->ordered()
            ->limit(6)
            ->get();

        return response()->json($featuredItems);
    }

    /**
     * Search gallery items by title or description
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $galleryItems = Gallery::active()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->ordered()
            ->get();

        return response()->json($galleryItems);
    }

    /**
     * Get all available categories
     */
    public function getCategories()
    {
        $categories = Gallery::active()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return response()->json($categories);
    }
}
