<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use InvalidArgumentException;

class ShipArmor
{
    /**
     * @throws InvalidArgumentException if the $armor value is less than 0.
     */
    public function __construct(private int $armor)
    {
        if ($armor < 0) {
            throw new InvalidArgumentException('Armor must be a positive integer');
        }
    }

    public function receiveDamage(int $damage): int
    {
        $this->armor -= $damage;
        return $this->armor < 0 ? abs($this->armor) : 0;
    }

    public function isDepleted(): bool
    {
        return $this->armor < 1;
    }
}
