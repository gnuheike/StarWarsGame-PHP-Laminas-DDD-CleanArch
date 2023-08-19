<?php

namespace StarWars\Domain\FleetCombat;

use StarWars\Domain\Ship\Ship;

interface ShipDamageProcessorServiceInterface
{
    public function processShipDamageToShip(Ship $damageEmitter, Ship $damageReceiver): void;
}
