<?php

namespace App\Http\Requests;

class ShipmentBulkAssignGroupRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', 'integer', 'exists:shipment_groups,id'],
            'shipment_ids' => ['required', 'array', 'min:1'],
            'shipment_ids.*' => ['required', 'integer', 'exists:shipments,id'],
        ];
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'shipment_ids.required' => 'At least one shipment ID is required.',
            'shipment_ids.array' => 'Shipment IDs must be an array.',
            'shipment_ids.min' => 'At least one shipment ID is required.',
            'shipment_ids.*.required' => 'Each shipment ID is required.',
            'shipment_ids.*.integer' => 'Each shipment ID must be an integer.',
            'shipment_ids.*.exists' => 'One or more selected shipments do not exist.',
        ]);
    }
}