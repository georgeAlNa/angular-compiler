<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UserResource;
use App\Exceptions\ModelNotFoundException;

class UserService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Update user information including profile photo
     */
    public function update(int $id, array $data): User
    {
        DB::beginTransaction();

        try {
            // Handle profile photo upload
            if (isset($data['profilePhoto']) && $data['profilePhoto'] instanceof \Illuminate\Http\UploadedFile) {
                $data = $this->handleProfilePhotoUpload($id, $data);
            }

            // Use BaseService update method
            $user = parent::update($id, $data);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update current authenticated user
     */
    public function updateCurrentUser(array $data): User
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        $role = $user->role;
        $userId = $user->id;

        // Extract driver/delivery_person fields from main data
        $driverFields = [];
        $deliveryPersonFields = [];
        $userFields = $data;

        if ($role === \App\Enums\Role::DRIVER) {
            // Extract driver-specific fields
            $driverFields = array_intersect_key($data, array_flip([
                'vehicle_description',
                'driving_license_number'
            ]));
            // Remove driver fields from user data
            $userFields = array_diff_key($data, $driverFields);
        } elseif ($role === \App\Enums\Role::DELIVERY_PERSON) {
            // Extract delivery person-specific fields
            $deliveryPersonFields = array_intersect_key($data, array_flip([
                'assigned_governorate_id',
                'vehicle_description',
                'driving_license_number'
            ]));
            // Remove delivery person fields from user data
            $userFields = array_diff_key($data, $deliveryPersonFields);
        }

        // Always update user info (with profile photo support)
        $user = $this->update($userId, $userFields);

        // Update related model if needed
        if ($role === \App\Enums\Role::DRIVER && !empty($driverFields)) {
            app(\App\Services\DriverService::class)->update($user->driver->id, $driverFields);
            // Reload with driver relation
            return $user->fresh(['driver']);
        } elseif ($role === \App\Enums\Role::DELIVERY_PERSON && !empty($deliveryPersonFields)) {
            app(\App\Services\DeliveryPersonService::class)->update($user->deliveryPerson->id, $deliveryPersonFields);
            // Reload with deliveryPerson relation
            return $user->fresh(['deliveryPerson']);
        }
        // For admin or customer, just return the updated user
        return $user;
    }

    /**
     * Handle profile photo upload and storage
     */
    private function handleProfilePhotoUpload(int $userId, array $data): array
    {
        $file = $data['profilePhoto'];

        // Validate file
        if (!$file->isValid()) {
            throw new \Exception('Invalid file upload');
        }

        // Get current user to check if there's an existing photo
        $currentUser = $this->findById($userId);

        // Generate unique filename
        $fileName = 'user_' . $userId . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Store the new file
        $path = $file->storeAs('public/user/photos', $fileName);

        if (!$path) {
            throw new \Exception('Failed to store profile photo');
        }

        // Delete old photo if exists
        if ($currentUser->photo) {
            $this->deleteProfilePhoto($currentUser->photo);
        }

        // Update data array with new photo path
        $data['photo'] = $fileName;

        // Remove the uploaded file from data array
        unset($data['profilePhoto']);

        return $data;
    }

    /**
     * Delete profile photo from storage
     */
    private function deleteProfilePhoto(string $fileName): bool
    {
        $path = 'public/user/photos/' . $fileName;

        if (Storage::exists($path)) {
            return Storage::delete($path);
        }

        return false;
    }

    /**
     * Get user with resource transformation
     */
    public function getUserWithResource(int $id): UserResource
    {
        $user = $this->findById($id);
        return new UserResource($user);
    }

    /**
     * Update user and return with resource transformation
     */
    public function updateWithResource(int $id, array $data): UserResource
    {
        $user = $this->update($id, $data);
        return new UserResource($user);
    }
}
