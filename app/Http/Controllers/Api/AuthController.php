<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Models\Driver;
use App\Models\DeliveryPerson;
use App\Enums\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Register a new user with role-based profile creation and token generation
     */
    public function register(Request $request): JsonResponse
    {
        // Define base validation rules
        $baseRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'age' => ['required', 'integer', 'min:18', 'max:100'],
            'role' => ['required', 'string', 'in:admin,customer,driver,delivery_person'],
        ];

        // Add role-specific validation rules
        $rules = $baseRules;
        $role = $request->input('role');

        if ($role === 'driver') {
            $rules['vehicle_description'] = ['required', 'string', 'max:255'];
            $rules['driving_license_number'] = ['required', 'string', 'max:50'];
        } elseif ($role === 'delivery_person') {
            $rules['vehicle_description'] = ['nullable', 'string', 'max:255'];
            $rules['driving_license_number'] = ['nullable', 'string', 'max:50'];
            $rules['assigned_governorate_id'] = ['nullable', 'integer', 'exists:governorates,id'];
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            // Map role string to enum
            $roleEnum = match($validated['role']) {
                'admin' => Role::ADMIN,
                'customer' => Role::CUSTOMER,
                'driver' => Role::DRIVER,
                'delivery_person' => Role::DELIVERY_PERSON,
            };

            $user = $this->userService->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'age' => $validated['age'],
                'role' => $roleEnum,
            ]);

            // Create role-specific profiles
            if ($user->role === Role::DRIVER) {
                Driver::create([
                    'user_id' => $user->id,
                    'vehicle_description' => $validated['vehicle_description'],
                    'driving_license_number' => $validated['driving_license_number'],
                ]);
            } elseif ($user->role === Role::DELIVERY_PERSON) {
                DeliveryPerson::create([
                    'user_id' => $user->id,
                    'vehicle_description' => $validated['vehicle_description'] ?? null,
                    'driving_license_number' => $validated['driving_license_number'] ?? null,
                    'assigned_governorate_id' => $validated['assigned_governorate_id'] ?? null,
                ]);
            }

            // Load relationships based on user role
            if ($user->role === Role::DRIVER) {
                $user->load('driver');
            } elseif ($user->role === Role::DELIVERY_PERSON) {
                $user->load('deliveryPerson.assignedGovernorate');
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'registered successfully',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login user
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        // Load relationships based on user role
        if ($user->role->value === 'driver') {
            $user->load('driver');
        } elseif ($user->role->value === 'delivery_person') {
            $user->load('deliveryPerson.assignedGovernorate');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
            'data' => null,
        ]);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        // Load relationships based on user role
        if ($user->role->value === 'driver') {
            $user->load('driver');
        } elseif ($user->role->value === 'delivery_person') {
            $user->load('deliveryPerson.assignedGovernorate');
        }

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully',
            'data' => new UserResource($user),
        ]);
    }
}
