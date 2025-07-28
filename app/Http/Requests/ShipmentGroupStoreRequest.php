<?php

namespace App\Http\Requests;

class ShipmentGroupStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'integer', 'exists:drivers,id'],
            'created_by_admin_id' => ['required', 'integer', 'exists:users,id'],
            'last_updated_by_admin_id' => ['required', 'integer', 'exists:users,id'],
            'from_governorate_id' => ['required', 'integer', 'exists:governorates,id'],
            'to_governorate_id' => ['required', 'integer', 'exists:governorates,id'],
            'from_center_id' => ['required', 'integer', 'exists:company_centers,id'],
            'to_center_id' => ['required', 'integer', 'exists:company_centers,id'],
            'route_description' => ['required', 'string', 'max:255'],
        ];
    }
}
