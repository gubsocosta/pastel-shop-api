<?php

namespace Core\Modules\Product\Application\UseCases\Create;

class CreateProductInput
{
    public function __construct(
        public readonly string $name,
        public readonly float  $price,
        public readonly string $photo
    )
    {
    }
}
