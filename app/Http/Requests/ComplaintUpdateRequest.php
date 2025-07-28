<?php

namespace App\Http\Requests;

class ComplaintUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'shipment_id' => 'sometimes|required|exists:shipments,id',
            'customer_id' => 'sometimes|required|exists:users,id',
            'description' => 'sometimes|required|string|max:255',
        ];
    }
}