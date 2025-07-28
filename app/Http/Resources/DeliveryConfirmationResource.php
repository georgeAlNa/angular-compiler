<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryConfirmationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shipment_id' => $this->shipment_id,
            'confirmed_by_delivery_person_id' => $this->confirmed_by_delivery_person_id,

            // Relationships
            'shipment' => new ShipmentResource($this->whenLoaded('shipment')),
            'confirmed_by_delivery_person' => new DeliveryPersonResource($this->whenLoaded('confirmedByDeliveryPerson')),
        ];
    }
}
