<?php

namespace App\Exceptions;

class NotFoundApiException extends ApiException
{
    public function __construct(
        string $message = 'Resource not found',
        array $meta = []
    ) {
        parent::__construct($message, 404, [], $meta);
    }
}