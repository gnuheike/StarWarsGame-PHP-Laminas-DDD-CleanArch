<?php

namespace StarWars\Domain\Battle;

use StarWars\Domain\Fleet\Fleet;

interface FleetCombatServiceInterface
{
    public function engage(Fleet $attackingFleet, Fleet $defendingFleet): void;
}
