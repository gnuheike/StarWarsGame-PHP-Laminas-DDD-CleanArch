<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use Exception;
use InvalidArgumentException;
use RuntimeException;

class ShipWeaponDamage
{
    public function __construct(
        private readonly int $min,
        private readonly int $max
    ) {
        if ($min < 0) {
            throw new InvalidArgumentException('Min must be greater than or equal to zero');
        }

        if ($max < 0) {
            throw new InvalidArgumentException('Max must be greater than or equal to zero');
        }

        if ($min > $max) {
            throw new InvalidArgumentException("Min must be less than or equal to max, got min: $min, max: $max");
        }
    }

    public function getDamageValue(): int
    {
        try {
            return random_int($this->min, $this->max);
        } catch (Exception $e) {
            throw new RuntimeException('Unable to generate damage number: ' . $e->getMessage());
        }
    }
}
