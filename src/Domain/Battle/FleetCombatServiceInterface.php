<?php

namespace StarWars\Domain\Battle;

interface FleetCombatServiceInterface
{
    public function engage(FleetInterface $attackingFleet, FleetInterface $defendingFleet): void;
}
