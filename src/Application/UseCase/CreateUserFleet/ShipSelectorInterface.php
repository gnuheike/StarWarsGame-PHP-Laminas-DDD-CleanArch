<?php

namespace StarWars\Application\UseCase\CreateUserFleet;

use StarWars\Domain\Fleet\ShipInterface;

interface ShipSelectorInterface
{
    public function selectShip(array $ships): ?ShipInterface;
}
