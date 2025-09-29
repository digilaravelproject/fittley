<?php

namespace App\Exceptions;

class AuthorizationApiException extends ApiException
{
    public function __construct(
        string $message = 'Access forbidden',
        array $meta = []
    ) {
        parent::__construct($message, 403, [], $meta);
    }
}