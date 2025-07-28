<?php

namespace App\Http\Requests;

class ShipmentStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:shipment_groups,id',
            'type_of_cargo' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'origin_address' => 'required|string|max:255',
            'destination_address' => 'required|string|max:255',
            'special_handling_instructions' => 'nullable|string|max:255',
            'origin_governorate_id' => 'required|exists:governorates,id',
            'destination_governorate_id' => 'required|exists:governorates,id',
            'origin_center_id' => 'nullable|exists:company_centers,id',
            'destination_center_id' => 'nullable|exists:company_centers,id',
            'assigned_delivery_person_id' => 'nullable|exists:delivery_persons,id',
            'status' => 'required|string|max:255',
            'qr_code' => 'required|string|max:255|unique:shipments,qr_code',
            'price' => 'required|numeric|min:0',
            'price_set_by_admin_id' => 'required|exists:users,id',
            'price_set_at' => 'required|date',
        ];
    }
}
