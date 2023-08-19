<?php

namespace StarWars\Domain\FleetCombat;

use StarWars\Domain\Ship\Ship;

interface ShipTargetSelectorServiceInterface
{
    /**
     * @param Ship[] $ships
     */
    public function getShipFromArray(array $ships): Ship;
}
