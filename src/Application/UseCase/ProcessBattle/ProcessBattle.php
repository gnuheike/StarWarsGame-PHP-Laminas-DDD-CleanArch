<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessBattle;

use StarWars\Domain\Battle\FleetInterface;

class ProcessBattle
{
    public function __construct(private readonly BattleFactoryInterface $battleFactory)
    {
    }

    public function __invoke(FleetInterface $playerFleet, FleetInterface $enemyFleet): BattleResult
    {
        $battle = $this->battleFactory->createBattle($playerFleet, $enemyFleet);

        $battleResult = new BattleResult($playerFleet->getShips(), $enemyFleet->getShips());

        $battleResult->incrementSteps();
        foreach ($battle->engage() as $ignored) {
            $battleResult->incrementSteps();
        }

        if ($playerFleet->isAlive()) {
            $battleResult->setWinner(BattleFleetEnum::PLAYER_FLEET);
        } else {
            $battleResult->setWinner(BattleFleetEnum::SITH_FLEET);
        }

        return $battleResult;
    }
}
