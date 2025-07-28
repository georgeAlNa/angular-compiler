<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Validation\Rule;

class UpdateDeliveryPersonRequest extends BaseRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $deliveryPersonId = $this->route('delivery_person')->id;

        return [
            'user_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('delivery_persons', 'user_id')->ignore($deliveryPersonId)
            ],
            'assigned_governorate_id' => ['sometimes', 'required', 'integer', 'exists:governorates,id'],
            'vehicle_description' => ['sometimes', 'string', 'max:255'],
            'driving_license_number' => ['sometimes', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'user',
            'assigned_governorate_id' => 'assigned governorate',
        ];
    }
}
