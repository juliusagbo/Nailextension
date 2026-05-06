<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::withCount('appointments')
            ->withSum('appointments', 'amount')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($users);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|in:customer,admin',
            'status' => 'sometimes|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = $validated['role'] ?? 'customer';
        $validated['status'] = $validated['status'] ?? 'active';

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        $user->load(['appointments.service']);
        return response()->json($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'sometimes|in:customer,admin',
            'status' => 'sometimes|in:active,inactive',
            'notes' => 'nullable|string',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function updateStatus(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User status updated successfully',
            'user' => $user
        ]);
    }

    public function getCustomers(): JsonResponse
    {
        $customers = User::byRole('customer')
            ->withCount('appointments')
            ->withSum('appointments', 'amount')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($customers);
    }

    public function getAdmins(): JsonResponse
    {
        $admins = User::byRole('admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($admins);
    }

    public function getActiveUsers(): JsonResponse
    {
        $users = User::active()
            ->withCount('appointments')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($users);
    }
}
