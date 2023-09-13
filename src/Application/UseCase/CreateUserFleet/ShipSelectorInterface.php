<?php

namespace StarWars\Application\UseCase\CreateUserFleet;

use StarWars\Domain\Ship\Ship;

interface ShipSelectorInterface
{
    public function selectShip(array $ships): ?Ship;
}
