<?php

namespace App\Http\Requests;

use App\Traits\HasEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShipmentGroupWithShipmentsAndCheckpointsRequest extends BaseRequest
{
    use HasEnums;

    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'integer', 'exists:drivers,id'],
            'from_governorate_id' => ['required', 'integer', 'exists:governorates,id'],
            'to_governorate_id' => ['required', 'integer', 'exists:governorates,id'],
            'from_center_id' => ['required', 'integer', 'exists:company_centers,id'],
            'to_center_id' => ['required', 'integer', 'exists:company_centers,id'],
            'route_description' => ['sometimes', 'string', 'max:1000'],
            'shipment_ids' => ['required', 'array', 'min:1'],
            'shipment_ids.*' => ['integer', 'exists:shipments,id'],
            'checkpoints' => ['required', 'array', 'min:1'],
            'checkpoints.*.checkpoint_id' => ['required', 'integer', 'exists:checkpoints,id'],
            'checkpoints.*.order' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'driver_id' => 'driver',
            'from_governorate_id' => 'from governorate',
            'to_governorate_id' => 'to governorate',
            'from_center_id' => 'from center',
            'to_center_id' => 'to center',
            'route_description' => 'route description',
            'shipment_ids' => 'shipments',
            'checkpoints' => 'checkpoints',
            'checkpoints.*.checkpoint_id' => 'checkpoint',
            'checkpoints.*.order' => 'order',
        ];
    }
}
