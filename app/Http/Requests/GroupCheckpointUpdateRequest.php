<?php

namespace App\Http\Requests;

class GroupCheckpointUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['sometimes', 'integer', 'exists:shipment_groups,id'],
            'checkpoint_id' => ['sometimes', 'integer', 'exists:checkpoints,id'],
            'order' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
