<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shipment_id' => $this->shipment_id,
            'customer_id' => $this->customer_id,
            'description' => $this->description,

            // Relationships
            'shipment' => new ShipmentResource($this->whenLoaded('shipment')),
            'customer' => new UserResource($this->whenLoaded('customer')),
        ];
    }
}
