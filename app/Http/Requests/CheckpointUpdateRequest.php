<?php

namespace App\Http\Requests;

class CheckpointUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'governorate_id' => ['sometimes', 'integer', 'exists:governorates,id'],
        ];
    }
}
