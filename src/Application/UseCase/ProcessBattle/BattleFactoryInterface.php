<?php

namespace StarWars\Application\UseCase\ProcessBattle;

use StarWars\Domain\Battle\Battle;
use StarWars\Domain\Fleet\Fleet;

interface BattleFactoryInterface
{
    public function createBattle(Fleet $playerFleet, Fleet $enemyFleet): Battle;
}
