<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception
{
    protected $message = 'Unauthorized access';
    protected $code = 401;

    public function __construct(string $message = null, int $code = 401, Exception $previous = null)
    {
        $this->message = $message ?? __('messages.unauthorized_access');
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
            'code' => 'UNAUTHORIZED_ACCESS'
        ], $this->code);
    }

    /**
     * Report the exception
     */
    public function report(): bool
    {
        // Report unauthorized access attempts
        return true;
    }
}