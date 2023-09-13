<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\ShipShields;

class ShipShieldsFactory
{
    public function createShipShields(
        int $value,
    ): ShipShields {
        return new ShipShields(
            value: $value,
        );
    }
}
