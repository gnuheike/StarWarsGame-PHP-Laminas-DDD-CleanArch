<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\ShipCost;

class ShipCostFactory
{
    public function createShipCost(
        int $value,
    ): ShipCost {
        return new ShipCost(
            value: $value,
        );
    }
}
