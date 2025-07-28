<?php

namespace App\Http\Requests;

class ShipmentUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        $shipmentId = $this->route('shipment') ? $this->route('shipment')->id : null;

        return [
            'sender_id' => 'sometimes|required|exists:users,id',
            'receiver_id' => 'sometimes|required|exists:users,id',
            'group_id' => 'sometimes|required|exists:shipment_groups,id',
            'type_of_cargo' => 'sometimes|required|string|max:255',
            'weight' => 'sometimes|required|numeric|min:0',
            'origin_address' => 'sometimes|required|string|max:255',
            'destination_address' => 'sometimes|required|string|max:255',
            'special_handling_instructions' => 'sometimes|nullable|string|max:255',
            'origin_governorate_id' => 'sometimes|required|exists:governorates,id',
            'destination_governorate_id' => 'sometimes|required|exists:governorates,id',
            'origin_center_id' => 'sometimes|nullable|exists:company_centers,id',
            'destination_center_id' => 'sometimes|nullable|exists:company_centers,id',
            'assigned_delivery_person_id' => 'sometimes|nullable|exists:delivery_persons,id',
            'status' => 'sometimes|required|string|max:255',
            'qr_code' => 'sometimes|required|string|max:255|unique:shipments,qr_code,' . $shipmentId,
            'price' => 'sometimes|required|numeric|min:0',
            'price_set_by_admin_id' => 'sometimes|required|exists:users,id',
            'price_set_at' => 'sometimes|required|date',
        ];
    }
}
