<?php

namespace App\Http\Requests;

class GovernorateStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}