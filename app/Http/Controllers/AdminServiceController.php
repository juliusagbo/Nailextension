<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display all services for admin
     */
    public function index()
    {
        $services = Service::orderBy('name')->get();
        return view('admin.services', compact('services'));
    }

    /**
     * Store a new service
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'servicePrice' => 'required|string',
                'description' => 'nullable|string',
                'category' => 'nullable|string',
                'status' => 'nullable|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle image upload
            $imageUrl = null;
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs('public/images/admin/services', $imageName);
                    
                    // Verify the file was actually stored
                    if ($imagePath && file_exists(storage_path('app/' . $imagePath))) {
                        $imageUrl = 'images/admin/services/' . $imageName;
                        Log::info('Image uploaded successfully', ['path' => $imagePath, 'url' => $imageUrl]);
                    } else {
                        Log::error('Image upload failed - file not found after storage', ['path' => $imagePath]);
                    }
                } catch (\Exception $e) {
                    Log::error('Image upload error: ' . $e->getMessage());
                }
            }

            // Create service with image URL and default values
            $serviceData = [
                'name' => $validated['name'],
                'price' => (float) str_replace(',', '', $validated['servicePrice']), // Convert to number and remove commas
                'description' => $validated['description'] ?? 'Service created by admin',
                'category' => $validated['category'] ?? 'general',
                'location_type' => 'both', // Default to both locations
                'status' => $validated['status'] ?? 'active',
                'duration_minutes' => 60, // Default 1 hour
                'image_url' => $imageUrl,
            ];

            $service = Service::create($serviceData);

            Log::info('Admin created new service', [
                'admin_id' => Auth::id(),
                'service_id' => $service->id,
                'service_name' => $validated['name'],
                'image_url' => $imageUrl,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service created successfully!',
                'service' => $service
            ]);

        } catch (\Exception $e) {
            Log::error('Admin service creation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a service
     */
    public function update(Request $request, Service $service): JsonResponse
    {
        try {
            Log::info('Admin service update request', [
                'service_id' => $service->id,
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'servicePrice' => 'sometimes|string',
                'description' => 'nullable|string',
                'category' => 'nullable|string',
                'status' => 'nullable|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            Log::info('Validated data', $validated);

            // Handle image upload if new image is provided
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs('public/images/admin/services', $imageName);
                    
                    // Verify the file was actually stored
                    if ($imagePath && file_exists(storage_path('app/' . $imagePath))) {
                        $validated['image_url'] = 'images/admin/services/' . $imageName;
                        Log::info('Image updated successfully', ['path' => $imagePath, 'url' => $validated['image_url']]);
                    } else {
                        Log::error('Image update failed - file not found after storage', ['path' => $imagePath]);
                    }
                } catch (\Exception $e) {
                    Log::error('Image update error: ' . $e->getMessage());
                }
            }

            // Prepare update data with proper field names and defaults
            $updateData = [];
            
            if (isset($validated['name'])) {
                $updateData['name'] = $validated['name'];
            }
            if (isset($validated['servicePrice'])) {
                $updateData['price'] = (float) str_replace(',', '', $validated['servicePrice']); // Convert to number and remove commas
            }
            if (isset($validated['description'])) {
                $updateData['description'] = $validated['description'];
            }
            if (isset($validated['category'])) {
                $updateData['category'] = $validated['category'];
            }
            if (isset($validated['status'])) {
                $updateData['status'] = $validated['status'];
            }
            if (isset($validated['image_url'])) {
                $updateData['image_url'] = $validated['image_url'];
            }
            
            // Set default values for required fields if not provided
            $updateData['location_type'] = 'both'; // Default to both locations
            $updateData['duration_minutes'] = 60; // Default 1 hour

            $service->update($updateData);

            Log::info('Admin updated service', [
                'admin_id' => Auth::id(),
                'service_id' => $service->id,
                'service_name' => $service->name,
                'update_data' => $updateData
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully!',
                'service' => $service->fresh() // Get updated service data
            ]);

        } catch (\Exception $e) {
            Log::error('Admin service update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a service
     */
    public function destroy(Service $service): JsonResponse
    {
        try {
            $serviceId = $service->id;
            $serviceName = $service->name;
            $service->delete();

            Log::info('Admin deleted service', [
                'admin_id' => Auth::id(),
                'service_id' => $serviceId,
                'service_name' => $serviceName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Admin service deletion error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get service statistics
     */
    public function getStatistics(): JsonResponse
    {
        $stats = [
            'total' => Service::count(),
            'active' => Service::where('status', 'active')->count(),
            'inactive' => Service::where('status', 'inactive')->count(),
            'home_service' => Service::where('location_type', 'home-service')->count(),
            'walk_in' => Service::where('location_type', 'walk-in')->count(),
        ];

        return response()->json($stats);
    }
}
