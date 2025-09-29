<?php

namespace App\Exceptions;

class AuthenticationApiException extends ApiException
{
    public function __construct(
        string $message = 'Authentication required',
        array $meta = []
    ) {
        parent::__construct($message, 401, [], $meta);
    }
}