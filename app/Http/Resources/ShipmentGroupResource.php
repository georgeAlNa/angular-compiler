<?php

namespace App\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentGroupResource extends JsonResource
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
            'driver_id' => $this->driver_id,
            'created_by_admin_id' => $this->created_by_admin_id,
            'last_updated_by_admin_id' => $this->last_updated_by_admin_id,
            'from_governorate_id' => $this->from_governorate_id,
            'to_governorate_id' => $this->to_governorate_id,
            'from_center_id' => $this->from_center_id,
            'to_center_id' => $this->to_center_id,
            'route_description' => $this->route_description,
            'status' => Status::from($this->status)->value,

            // Relationships
            'driver' => new \App\Http\Resources\DriverResource($this->whenLoaded('driver')),
            'created_by_admin' => new \App\Http\Resources\UserResource($this->whenLoaded('createdByAdmin')),
            'last_updated_by_admin' => new \App\Http\Resources\UserResource($this->whenLoaded('lastUpdatedByAdmin')),
            'from_governorate' => new \App\Http\Resources\GovernorateResource($this->whenLoaded('fromGovernorate')),
            'to_governorate' => new \App\Http\Resources\GovernorateResource($this->whenLoaded('toGovernorate')),
            'from_center' => new \App\Http\Resources\CompanyCenterResource($this->whenLoaded('fromCenter')),
            'to_center' => new \App\Http\Resources\CompanyCenterResource($this->whenLoaded('toCenter')),
            'group_checkpoints' => \App\Http\Resources\GroupCheckpointResource::collection($this->whenLoaded('groupCheckpoints')),
            'shipments' => \App\Http\Resources\ShipmentResource::collection($this->whenLoaded('shipments')),
        ];
    }
}
