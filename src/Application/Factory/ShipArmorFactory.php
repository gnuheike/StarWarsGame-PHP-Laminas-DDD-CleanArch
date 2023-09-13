<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\ShipArmor;

class ShipArmorFactory
{
    public function createShipArmor(
        int $value,
    ): ShipArmor {
        return new ShipArmor(
            value: $value,
        );
    }
}
