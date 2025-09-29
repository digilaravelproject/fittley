<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ApiException extends Exception
{
    protected int $statusCode;
    protected array $errors;
    protected array $meta;

    public function __construct(
        string $message = 'An error occurred',
        int $statusCode = 400,
        array $errors = [],
        array $meta = [],
        Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        
        $this->statusCode = $statusCode;
        $this->errors = $errors;
        $this->meta = $meta;
    }

    /**
     * Get the HTTP status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get the errors array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the meta array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * Render the exception as an HTTP response
     */
    public function render(): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $this->getMessage(),
            'data' => null,
            'meta' => array_merge([
                'timestamp' => now()->toISOString(),
                'version' => '1.0'
            ], $this->meta)
        ];

        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }

        return response()->json($response, $this->statusCode);
    }
}