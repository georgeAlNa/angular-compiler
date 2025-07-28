<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Validation\Rule;
use App\Traits\HasEnums;

class UpdateUserRequest extends BaseRequest
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
        $userId = $this->user() ? $this->user()->id : null;
        $role = $this->user() ? $this->user()->role : null;

        $rules = [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'phone' => ['sometimes', 'required', 'string', 'max:20'],
            'address' => ['sometimes', 'required', 'string', 'max:500'],
            'age' => ['sometimes', 'required', 'integer', 'min:18', 'max:100'],
            'role' => array_merge(['sometimes', 'required'], explode('|', HasEnums::getEnumValidationRule(Role::class))),
            'profile_photo' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        if ($role === \App\Enums\Role::DRIVER) {
            $rules['vehicle_description'] = ['sometimes', 'string', 'max:255'];
            $rules['driving_license_number'] = ['sometimes', 'string', 'max:255'];
        } elseif ($role === \App\Enums\Role::DELIVERY_PERSON) {
            $rules['assigned_governorate_id'] = ['sometimes', 'integer', 'exists:governorates,id'];
            $rules['vehicle_description'] = ['sometimes', 'string', 'max:255'];
            $rules['driving_license_number'] = ['sometimes', 'string', 'max:255'];
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
        $attributes = [
            'name' => 'full name',
            'email' => 'email address',
            'password' => 'password',
            'phone' => 'phone number',
            'address' => 'address',
            'age' => 'age',
            'role' => 'user role',
            'profile_photo' => 'profile photo',
        ];

        $role = $this->user() ? $this->user()->role : null;

        if ($role === \App\Enums\Role::DRIVER) {
            $attributes['vehicle_description'] = 'vehicle description';
            $attributes['driving_license_number'] = 'driving license number';
        } elseif ($role === \App\Enums\Role::DELIVERY_PERSON) {
            $attributes['assigned_governorate_id'] = 'assigned governorate';
            $attributes['vehicle_description'] = 'vehicle description';
            $attributes['driving_license_number'] = 'driving license number';
        }

        return $attributes;
    }
}
