<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ValidationException extends Exception
{
    protected $errors;
    protected $message = 'Validation failed';
    protected $code = 422;

    public function __construct(array $errors = [], string $message = null, int $code = 422, Exception $previous = null)
    {
        $this->errors = $errors;
        $this->message = $message ?? __('messages.validation_failed');
        $this->code = $code;
        
        parent::__construct($this->message, $this->code, $previous);
    }

    /**
     * Get validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Render the exception as an HTTP response
     */
    public function render(): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $this->message,
            'code' => 'VALIDATION_ERROR'
        ];

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return response()->json($response, $this->code);
    }

    /**
     * Report the exception
     */
    public function report(): bool
    {
        // Don't report validation errors to logs by default
        return false;
    }
}