<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryPersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'assigned_governorate_id' => $this->assigned_governorate_id,

            // User information
            'user' => new UserResource($this->whenLoaded('user')),

            'vehicle_description' => $this->vehicle_description,
            'driving_license_number' => $this->driving_license_number,

            // Governorate information
            'assigned_governorate' => $this->whenLoaded('assignedGovernorate', function () {
                return [
                    'id' => $this->assignedGovernorate->id,
                    'name' => $this->assignedGovernorate->name,
                ];
            }),
        ];
    }
}
