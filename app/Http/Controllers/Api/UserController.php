<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Resources\DriverResource;
use App\Http\Resources\DeliveryPersonResource;
use App\Http\Requests\UpdateUserRequest;

class UserController extends BaseController
{
    public UserService $userService;
    public function __construct(UserService $userService)
    {
        parent::__construct($userService);
        $this->resourceClass = UserResource::class;
        $this->updateRequestClass = \App\Http\Requests\UpdateUserRequest::class;
        $this->userService = $userService;
    }

    /**
     * Update user with profile photo support
     */
    public function updateUser(UpdateUserRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $user = $this->userService->updateWithResource($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update current authenticated user
     */
    public function updateProfile(UpdateUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = $this->userService->updateCurrentUser($validated);

            if ($user->role === \App\Enums\Role::DRIVER) {
                $data = [
                    'user' => new UserResource($user),
                    'driver' => new DriverResource($user->driver)
                ];
            } elseif ($user->role === \App\Enums\Role::DELIVERY_PERSON) {
                $data = [
                    'user' => new UserResource($user),
                    'delivery_person' => new DeliveryPersonResource($user->deliveryPerson)
                ];
            } else {
                $data = new UserResource($user);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
