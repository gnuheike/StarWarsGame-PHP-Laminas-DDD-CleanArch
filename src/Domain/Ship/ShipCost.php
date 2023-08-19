<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

class ShipCost
{
    public function __construct(private readonly int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
