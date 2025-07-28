<?php

namespace App\Http\Requests;

class DeliveryConfirmationStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'shipment_id' => 'required|exists:shipments,id',
            'confirmed_by_delivery_person_id' => 'required|exists:delivery_persons,id',
        ];
    }
}
