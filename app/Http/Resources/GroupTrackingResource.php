<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupTrackingResource extends JsonResource
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
            'group_id' => $this->group_id,
            'checkpoint_id' => $this->checkpoint_id,
            'arrival_time' => $this->arrival_time?->toISOString(),

            // Relationship information
            'shipment_group' => new ShipmentGroupResource($this->whenLoaded('shipmentGroup')),
            'checkpoint' => new CheckpointResource($this->whenLoaded('checkpoint')),
        ];
    }
}
