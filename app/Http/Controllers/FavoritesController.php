<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with(['service' => function($query) {
                $query->where('status', 'active');
            }])
            ->whereHas('service', function($query) {
                $query->where('status', 'active');
            })
            ->get();
            
        return view('favorites', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id'
        ]);

        $userId = Auth::id();
        $serviceId = $request->service_id;

        $existingFavorite = Favorite::where('user_id', $userId)
            ->where('service_id', $serviceId)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Service removed from favorites']);
        } else {
            Favorite::create([
                'user_id' => $userId,
                'service_id' => $serviceId
            ]);
            return response()->json(['status' => 'added', 'message' => 'Service added to favorites']);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'favorite_id' => 'required|exists:favorites,id'
        ]);

        $favorite = Favorite::where('id', $request->favorite_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $favorite->delete();

        return response()->json(['status' => 'success', 'message' => 'Service removed from favorites']);
    }

    public function count()
    {
        $count = Favorite::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }
}
