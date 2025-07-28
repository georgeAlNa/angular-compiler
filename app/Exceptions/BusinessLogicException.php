<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BusinessLogicException extends Exception
{
    protected $message = 'Business logic error';
    protected $code = 400;

    public function __construct(string $message = null, int $code = 400, Exception $previous = null)
    {
        $this->message = $message ?? __('messages.business_logic_error');
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
            'code' => 'BUSINESS_LOGIC_ERROR'
        ], $this->code);
    }

    /**
     * Report the exception
     */
    public function report(): bool
    {
        // Report business logic errors for debugging
        return true;
    }
}