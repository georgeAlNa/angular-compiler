<?php

namespace App\Http\Requests;

class ComplaintStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'shipment_id' => 'required|exists:shipments,id',
            'customer_id' => 'required|exists:users,id',
            'description' => 'required|string|max:255',
        ];
    }
}