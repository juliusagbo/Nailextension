<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::active()->get();
        return response()->json($services);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'category' => 'required|string|max:255',
            'location_type' => 'required|in:home-service,walk-in,both',
            'status' => 'required|in:active,inactive',
            'image_url' => 'nullable|url',
        ]);

        $service = Service::create($validated);

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service
        ], 201);
    }

    public function show(Service $service): JsonResponse
    {
        return response()->json($service);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'duration_minutes' => 'sometimes|integer|min:15',
            'category' => 'sometimes|string|max:255',
            'location_type' => 'sometimes|in:home-service,walk-in,both',
            'status' => 'sometimes|in:active,inactive',
            'image_url' => 'nullable|url',
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service
        ]);
    }

    public function destroy(Service $service): JsonResponse
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }

    public function getByCategory($category): JsonResponse
    {
        $services = Service::active()->byCategory($category)->get();
        return response()->json($services);
    }

    public function getByLocation($locationType): JsonResponse
    {
        $services = Service::active()->byLocation($locationType)->get();
        return response()->json($services);
    }
}
