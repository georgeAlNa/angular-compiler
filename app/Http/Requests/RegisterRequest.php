<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Traits\HasEnums;

class RegisterRequest extends BaseRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'age' => ['required', 'integer', 'min:18', 'max:100'],
            'role' => array_merge(['required'], explode('|', HasEnums::getEnumValidationRule(Role::class))),
        ];

        // Add role-specific validation rules
        if ($this->input('role') === Role::DRIVER->value) {
            $rules['vehicle_description'] = ['required', 'string', 'max:255'];
            $rules['driving_license_number'] = ['required', 'string', 'max:50'];
        } elseif ($this->input('role') === Role::DELIVERY_PERSON->value) {
            $rules['vehicle_description'] = ['nullable', 'string', 'max:255'];
            $rules['driving_license_number'] = ['nullable', 'string', 'max:50'];
            $rules['assigned_governorate_id'] = ['nullable', 'integer', 'exists:governorates,id'];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'full name',
            'email' => 'email address',
            'password' => 'password',
            'phone' => 'phone number',
            'address' => 'address',
            'age' => 'age',
            'role' => 'user role',
            'vehicle_description' => 'vehicle description',
            'driving_license_number' => 'driving license number',
            'assigned_governorate_id' => 'assigned governorate',
        ];
    }
}
