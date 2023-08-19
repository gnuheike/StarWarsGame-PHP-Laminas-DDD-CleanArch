<?php

namespace StarWars\Application\UseCase\ProcessBattle;

use StarWars\Domain\Battle\Battle;
use StarWars\Domain\Battle\FleetInterface;

interface BattleFactoryInterface
{
    public function createBattle(FleetInterface $playerFleet, FleetInterface $enemyFleet): Battle;
}
