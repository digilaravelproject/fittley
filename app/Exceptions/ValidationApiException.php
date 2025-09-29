<?php

namespace App\Exceptions;

class ValidationApiException extends ApiException
{
    public function __construct(
        array $errors,
        string $message = 'Validation failed',
        array $meta = []
    ) {
        parent::__construct($message, 422, $errors, $meta);
    }
}