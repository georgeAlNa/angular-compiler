<?php

namespace App\Http\Requests;

class DeliveryConfirmationUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'shipment_id' => 'sometimes|required|exists:shipments,id',
            'confirmed_by_delivery_person_id' => 'sometimes|required|exists:delivery_persons,id',
        ];
    }
}
