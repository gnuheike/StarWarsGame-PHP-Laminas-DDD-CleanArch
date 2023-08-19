<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

class ShipName
{
    public function __construct(private readonly string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
