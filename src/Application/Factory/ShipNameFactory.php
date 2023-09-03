<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\ShipName;

class ShipNameFactory
{
    public function createShipName(string $name): ShipName
    {
        return new ShipName(
            value: $name
        );
    }
}
