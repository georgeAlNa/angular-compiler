<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shipment_id' => $this->shipment_id,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'payment_date' => $this->payment_date,

            // Relationships
            'shipment' => new ShipmentResource($this->whenLoaded('shipment')),
        ];
    }
}
