<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessBattle;

use StarWars\Domain\Fleet\Fleet;

class ProcessBattle
{
    public function __construct(private readonly BattleFactory $battleFactory)
    {
    }

    public function __invoke(Fleet $playerFleet, Fleet $enemyFleet): BattleResult
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
