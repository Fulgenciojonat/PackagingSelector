<?php

namespace App\Models;

class Box
{
    private static array $boxConfigurations = [
        ["name" => "BOXA", "length" => 20, "width" => 15, "height" => 10, "weight_limit" => 5],
        ["name" => "BOXB", "length" => 30, "width" => 25, "height" => 20, "weight_limit" => 10],
        ["name" => "BOXC", "length" => 60, "width" => 55, "height" => 50, "weight_limit" => 50],
        ["name" => "BOXD", "length" => 50, "width" => 45, "height" => 40, "weight_limit" => 30],
        ["name" => "BOXE", "length" => 40, "width" => 35, "height" => 30, "weight_limit" => 20],
    ];

    public function __construct(
        public readonly string $name,
        public readonly int $length,
        public readonly int $width,
        public readonly int $height,
        public readonly int $weight_limit
    ) {}

    public static function getBoxConfigurations(): array
    {
        return self::$boxConfigurations;
    }

    public static function createFromConfiguration(array $config): self
    {
        return new self(
            $config['name'],
            (int)$config['length'],
            (int)$config['width'],
            (int)$config['height'],
            (int)$config['weight_limit']
        );
    }
}
