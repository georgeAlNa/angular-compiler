<?php

namespace App\Http\Requests;

class ShipmentGroupUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'driver_id' => ['sometimes', 'integer', 'exists:drivers,id'],
            'created_by_admin_id' => ['sometimes', 'integer', 'exists:users,id'],
            'last_updated_by_admin_id' => ['sometimes', 'integer', 'exists:users,id'],
            'from_governorate_id' => ['sometimes', 'integer', 'exists:governorates,id'],
            'to_governorate_id' => ['sometimes', 'integer', 'exists:governorates,id'],
            'from_center_id' => ['sometimes', 'integer', 'exists:company_centers,id'],
            'to_center_id' => ['sometimes', 'integer', 'exists:company_centers,id'],
            'route_description' => ['sometimes', 'string', 'max:255'],

            'shipment_ids' => ['sometimes', 'array'],
            'shipment_ids.*' => ['integer', 'distinct', 'exists:shipments,id'],

            'checkpoints' => ['sometimes', 'array'],
            'checkpoints.*.checkpoint_id' => ['required_with:checkpoints', 'integer', 'exists:checkpoints,id'],
            'checkpoints.*.order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
