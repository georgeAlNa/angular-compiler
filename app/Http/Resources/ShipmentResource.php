<?php

namespace App\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'group_id' => $this->group_id,
            'type_of_cargo' => $this->type_of_cargo,
            'weight' => $this->weight,
            'origin_address' => $this->origin_address,
            'destination_address' => $this->destination_address,
            'special_handling_instructions' => $this->special_handling_instructions,
            'origin_governorate_id' => $this->origin_governorate_id,
            'destination_governorate_id' => $this->destination_governorate_id,
            'origin_center_id' => $this->origin_center_id,
            'destination_center_id' => $this->destination_center_id,
            'status' => Status::from($this->status)->value,
            'qr_code' => $this->qr_code,
            'price' => $this->price,
            'price_set_by_admin_id' => $this->price_set_by_admin_id,
            'price_set_at' => $this->price_set_at,
            'assigned_delivery_person_id' => $this->assigned_delivery_person_id,

            // Relationships
            'sender' => new UserResource($this->whenLoaded('sender')),
            'receiver' => new UserResource($this->whenLoaded('receiver')),
            'shipment_group' => new ShipmentGroupResource($this->whenLoaded('shipmentGroup')),
            'origin_governorate' => new GovernorateResource($this->whenLoaded('originGovernorate')),
            'destination_governorate' => new GovernorateResource($this->whenLoaded('destinationGovernorate')),
            'origin_center' => new CompanyCenterResource($this->whenLoaded('originCenter')),
            'destination_center' => new CompanyCenterResource($this->whenLoaded('destinationCenter')),
            'price_set_by_admin' => new UserResource($this->whenLoaded('priceSetByAdmin')),
            'delivery_confirmation' => new DeliveryConfirmationResource($this->whenLoaded('deliveryConfirmation')),
            'assigned_delivery_person' => new DeliveryPersonResource($this->whenLoaded('assignedDeliveryPerson')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'complaints' => ComplaintResource::collection($this->whenLoaded('complaints')),
        ];
    }
}
