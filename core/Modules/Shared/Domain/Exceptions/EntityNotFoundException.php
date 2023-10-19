<?php

namespace Core\Modules\Shared\Domain\Exceptions;

use Exception;
use Throwable;

class EntityNotFoundException extends Exception
{
    public function __construct(string $entityName, int $code = 0, ?Throwable $previous = null)
    {
        $message = "'$entityName' not found";
        parent::__construct($message, $code, $previous);
    }
}
