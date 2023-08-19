<?php

declare(strict_types=1);

namespace StarWars\Infrastructure\Factory;

use StarWars\Application\UseCase\ProcessBattle\BattleFactoryInterface;
use StarWars\Domain\Battle\Battle;
use StarWars\Domain\Battle\FleetCombatServiceInterface;
use StarWars\Domain\Battle\FleetInterface;

final class BattleFactory implements BattleFactoryInterface
{
    public function __construct(private readonly FleetCombatServiceInterface $fleetCombatService)
    {
    }

    public function createBattle(FleetInterface $playerFleet, FleetInterface $enemyFleet): Battle
    {
        return new Battle($playerFleet, $enemyFleet, $this->fleetCombatService);
    }
}
