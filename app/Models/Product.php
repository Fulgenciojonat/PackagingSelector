<?php

declare(strict_types=1);

namespace App\Models;

class Product
{
    public function __construct(
        public int $length = 0,
        public int $width = 0,
        public int $height = 0,
        public int $weight = 0,
        public int $quantity = 0
    ) {}

    public function __toString(): string
    {
        return $this->length . ',' . $this->width . ',' . $this->height . ',' . $this->weight . ',' . $this->quantity;
    }
}
