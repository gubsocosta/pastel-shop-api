<?php

namespace Core\Modules\Product\Domain\Exceptions;

use Exception;
use Throwable;

final class ProductNameHasAlreadyBeenUsedException extends Exception
{
    public function __construct(string $productName, int $code = 0, ?Throwable $previous = null)
    {
        $message = "the product name '$productName' has already been used";
        parent::__construct($message, $code, $previous);
    }
}
