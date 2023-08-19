<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use InvalidArgumentException;

class ShipShields
{
    /**
     * @throws InvalidArgumentException If the number of shields is less than 0.
     */
    public function __construct(private int $shields)
    {
        if ($shields < 0) {
            throw new InvalidArgumentException('Shields must be a positive integer');
        }
    }

    public function receiveDamage(int $damage): int
    {
        $this->shields -= $damage;
        return $this->shields < 0 ? abs($this->shields) : 0;
    }

    public function isDepleted(): bool
    {
        return $this->shields < 1;
    }
}
