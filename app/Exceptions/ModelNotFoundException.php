<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ModelNotFoundException extends Exception
{
    protected $message = 'Record not found';
    protected $code = 404;

    public function __construct(string $message = null, int $code = 404, Exception $previous = null)
    {
        $this->message = $message ?? __('messages.record_not_found');
        $this->code = $code;
        
        parent::__construct($this->message, $this->code, $previous);
    }

    /**
     * Render the exception as an HTTP response
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
            'code' => 'MODEL_NOT_FOUND'
        ], $this->code);
    }

    /**
     * Report the exception
     */
    public function report(): bool
    {
        // Don't report 404 errors to logs by default
        return false;
    }
}