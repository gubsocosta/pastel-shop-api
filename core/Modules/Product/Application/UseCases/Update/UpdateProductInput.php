<?php

namespace Core\Modules\Product\Application\UseCases\Update;

class UpdateProductInput
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly float  $price,
        public readonly string $photo
    )
    {
    }
}
