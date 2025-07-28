<?php

namespace App\Http\Requests;

class PaymentStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'shipment_id' => 'required|exists:shipments,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|date',
        ];
    }
}
