<?php

namespace App\Http\Requests;

class GroupCheckpointBulkCreateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', 'integer', 'exists:shipment_groups,id'],
            'checkpoints' => ['required', 'array', 'min:1'],
            'checkpoints.*.checkpoint_id' => ['required', 'integer', 'exists:checkpoints,id'],
            'checkpoints.*.order' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'checkpoints.required' => 'At least one checkpoint is required.',
            'checkpoints.array' => 'Checkpoints must be an array.',
            'checkpoints.min' => 'At least one checkpoint is required.',
            'checkpoints.*.checkpoint_id.required' => 'Each checkpoint must have a checkpoint_id.',
            'checkpoints.*.checkpoint_id.exists' => 'The selected checkpoint does not exist.',
            'checkpoints.*.order.required' => 'Each checkpoint must have an order.',
            'checkpoints.*.order.min' => 'Order must be at least 1.',
        ]);
    }
}