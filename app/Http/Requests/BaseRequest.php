<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request
     */
    abstract public function rules(): array;

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            // Required field messages
            '*.required' => __('validation.required'),

            // String validation messages
            '*.string' => __('validation.string'),
            '*.min' => __('validation.min.string'),
            '*.max' => __('validation.max.string'),

            // Numeric validation messages
            '*.integer' => __('validation.integer'),
            '*.numeric' => __('validation.numeric'),
            '*.min' => __('validation.min.numeric'),
            '*.max' => __('validation.max.numeric'),

            // Email validation messages
            '*.email' => __('validation.email'),

            // Date validation messages
            '*.date' => __('validation.date'),
            '*.date_format' => __('validation.date_format'),
            '*.after' => __('validation.after'),
            '*.before' => __('validation.before'),

            // Array validation messages
            '*.array' => __('validation.array'),

            // Boolean validation messages
            '*.boolean' => __('validation.boolean'),

            // File validation messages
            '*.file' => __('validation.file'),
            '*.image' => __('validation.image'),
            '*.mimes' => __('validation.mimes'),
            '*.max' => __('validation.max.file'),

            // Unique validation messages
            '*.unique' => __('validation.unique'),

            // Exists validation messages
            '*.exists' => __('validation.exists'),

            // Confirmed validation messages
            '*.confirmed' => __('validation.confirmed'),

            // In validation messages
            '*.in' => __('validation.in'),

            // URL validation messages
            '*.url' => __('validation.url'),

            // JSON validation messages
            '*.json' => __('validation.json'),
        ];
    }

    /**
     * Get custom attributes for validator errors
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Handle a failed validation attempt
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->toArray();

        $response = new JsonResponse([
            'success' => false,
            'message' => __('messages.validation_failed'),
            'errors' => $errors,
            'code' => 'VALIDATION_ERROR'
        ], 422);

        throw new HttpResponseException($response);
    }

    /**
     * Configure the validator instance
     */
    public function withValidator(Validator $validator): void
    {
        // Override in child classes if needed
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation(): void
    {
        // Override in child classes if needed
    }

    /**
     * Get validated data with only specified keys
     */
    public function validatedOnly(array $keys): array
    {
        return collect($this->validated())
            ->only($keys)
            ->toArray();
    }

    /**
     * Get validated data except specified keys
     */
    public function validatedExcept(array $keys): array
    {
        return collect($this->validated())
            ->except($keys)
            ->toArray();
    }

    /**
     * Get input with default value if not present
     */
    public function inputWithDefault(string $key, $default = null)
    {
        return $this->has($key) ? $this->input($key) : $default;
    }
}
