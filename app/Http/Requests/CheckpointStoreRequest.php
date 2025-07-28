<?php

namespace App\Http\Requests;

class CheckpointStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'governorate_id' => ['required', 'integer', 'exists:governorates,id'],
        ];
    }
}
