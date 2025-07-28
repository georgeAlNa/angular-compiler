<?php

namespace App\Http\Requests;

class PaymentUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'shipment_id' => 'sometimes|required|exists:shipments,id',
            'amount' => 'sometimes|required|numeric|min:0',
            'payment_method' => 'sometimes|required|string|max:255',
            'payment_date' => 'sometimes|required|date',
        ];
    }
}