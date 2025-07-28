<?php

namespace App\Http\Requests;

class StoreCompanyCenterRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:company_centers,name',
            'location' => 'required|string|max:255',
            'governorate_id' => 'required|exists:governorates,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('messages.validation.required', ['attribute' => __('attributes.name')]),
            'name.unique' => __('messages.validation.unique', ['attribute' => __('attributes.name')]),
            'location.required' => __('messages.validation.required', ['attribute' => __('attributes.location')]),
            'governorate_id.required' => __('messages.validation.required', ['attribute' => __('attributes.governorate')]),
            'governorate_id.exists' => __('messages.validation.exists', ['attribute' => __('attributes.governorate')]),
        ];
    }
}