<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'age' => $this->age,
            'role' => [
                'value' => $this->role->value,
                'name' => $this->role->name,
            ],
            'profile_photo_url' => $this->profile_photo_url,
        ];

        // Add driver information if user is a driver
        if ($this->role->value === 'driver' && $this->driver) {
            $data['driver_profile'] = [
                'id' => $this->driver->id,
                'vehicle_description' => $this->driver->vehicle_description,
                'driving_license_number' => $this->driver->driving_license_number,
                'created_at' => $this->driver->created_at,
                'updated_at' => $this->driver->updated_at,
            ];
        }

        // Add delivery person information if user is a delivery person
        if ($this->role->value === 'delivery_person' && $this->deliveryPerson) {
            $data['delivery_person_profile'] = [
                'id' => $this->deliveryPerson->id,
                'vehicle_description' => $this->deliveryPerson->vehicle_description,
                'driving_license_number' => $this->deliveryPerson->driving_license_number,
                'assigned_governorate_id' => $this->deliveryPerson->assigned_governorate_id,
                'assigned_governorate' => $this->deliveryPerson->assignedGovernorate ? [
                    'id' => $this->deliveryPerson->assignedGovernorate->id,
                    'name' => $this->deliveryPerson->assignedGovernorate->name,
                ] : null,
                'created_at' => $this->deliveryPerson->created_at,
                'updated_at' => $this->deliveryPerson->updated_at,
            ];
        }

        return $data;
    }
}
