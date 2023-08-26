<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessBattle;

use StarWars\Domain\Battle\Battle;
use StarWars\Domain\Fleet\Fleet;

class BattleFactory
{
    public function __construct()
    {
    }

    public function createBattle(Fleet $playerFleet, Fleet $enemyFleet): Battle
    {
        return new Battle($playerFleet, $enemyFleet);
    }
}
