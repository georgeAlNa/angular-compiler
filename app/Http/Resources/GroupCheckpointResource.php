<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupCheckpointResource extends JsonResource
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
            'order' => $this->order,

            // Relationships
            'group' => new ShipmentGroupResource($this->whenLoaded('group')),
            'checkpoint' => new CheckpointResource($this->whenLoaded('checkpoint')),
        ];
    }
}
