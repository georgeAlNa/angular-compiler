<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Validation\Rule;

class UpdateDriverRequest extends BaseRequest
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
        $driverId = $this->route('driver')->id;

        return [
            'user_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('drivers', 'user_id')->ignore($driverId)
            ],
            'vehicle_description' => ['sometimes', 'required', 'string', 'max:500'],
            'driving_license_number' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('drivers', 'driving_license_number')->ignore($driverId)
            ],
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
            'vehicle_description' => 'vehicle description',
            'driving_license_number' => 'driving license number',
        ];
    }
}
