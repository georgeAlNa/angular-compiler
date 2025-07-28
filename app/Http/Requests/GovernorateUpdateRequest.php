<?php

namespace App\Http\Requests;

class GovernorateUpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
        ];
    }
}