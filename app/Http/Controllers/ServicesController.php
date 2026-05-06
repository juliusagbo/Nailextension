<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{
    public function index()
    {
        // Get only active services for the services page
        $services = Service::active()->get();
        
        // Get user's favorites for this page
        $userFavorites = [];
        if (Auth::check()) {
            $userFavorites = Favorite::where('user_id', Auth::id())
                ->pluck('service_id')
                ->toArray();
        }
        
        return view('services', compact('services', 'userFavorites'));
    }
}
