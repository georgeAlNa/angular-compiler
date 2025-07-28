<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AddShipmentRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
            'type_of_cargo' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:1000'],
            'origin_address' => ['required', 'string', 'max:500'],
            'destination_address' => ['required', 'string', 'max:500'],
            'special_handling_instructions' => ['nullable', 'string', 'max:1000'],
            'origin_governorate_id' => ['required', 'integer', 'exists:governorates,id'],
            'destination_governorate_id' => ['required', 'integer', 'exists:governorates,id'],
            'origin_center_id' => ['required', 'integer', 'exists:company_centers,id'],
            'destination_center_id' => ['required', 'integer', 'exists:company_centers,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'receiver_id' => 'receiver',
            'type_of_cargo' => 'type of cargo',
            'weight' => 'weight',
            'origin_address' => 'origin address',
            'destination_address' => 'destination address',
            'special_handling_instructions' => 'special handling instructions',
            'origin_governorate_id' => 'origin governorate',
            'destination_governorate_id' => 'destination governorate',
            'origin_center_id' => 'origin center',
            'destination_center_id' => 'destination center',
        ];
    }
}
