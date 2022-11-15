<?php

namespace Ofload\Butn\Exceptions;

use Throwable;

class ButnServerException extends \Exception
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}