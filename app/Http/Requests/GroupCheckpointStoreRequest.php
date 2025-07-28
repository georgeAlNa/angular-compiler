<?php

namespace App\Http\Requests;

class GroupCheckpointStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', 'integer', 'exists:shipment_groups,id'],
            'checkpoint_id' => ['required', 'integer', 'exists:checkpoints,id'],
            'order' => ['required', 'integer', 'min:1'],
        ];
    }
}
