<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use InvalidArgumentException;

class ShipArmor
{
    /**
     * @throws InvalidArgumentException if the $armor value is less than 0.
     */
    public function __construct(private int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Armor must be a positive integer');
        }
    }

    public function receiveDamage(int $damage): int
    {
        $this->value -= $damage;
        return $this->value < 0 ? abs($this->value) : 0;
    }

    public function isDepleted(): bool
    {
        return $this->value < 1;
    }
}
