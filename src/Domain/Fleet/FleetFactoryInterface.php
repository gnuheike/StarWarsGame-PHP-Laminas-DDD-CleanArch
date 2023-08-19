<?php

namespace StarWars\Domain\Fleet;

use StarWars\Domain\Battle\FleetInterface;

interface FleetFactoryInterface
{
    /**
     * @param ShipInterface[] $ships
     * @return FleetInterface
     */
    public function createFleet(array $ships): FleetInterface;
}
