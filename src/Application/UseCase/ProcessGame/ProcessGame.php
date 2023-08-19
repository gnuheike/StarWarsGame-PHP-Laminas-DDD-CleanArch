<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessGame;

use StarWars\Application\UseCase\CreateSithFleet\CreateSithFleet;
use StarWars\Application\UseCase\CreateUserFleet\CreateUserFleet;
use StarWars\Application\UseCase\GetPlayerFleet\GetPlayerFleet;
use StarWars\Application\UseCase\GetSithFleet\GetSithFleet;
use StarWars\Application\UseCase\ProcessBattle\ProcessBattle;

final class ProcessGame
{
    public function __construct(
        private readonly CreateSithFleet $createSithFleet,
        private readonly CreateUserFleet $createUserFleet,
        private readonly GetPlayerFleet  $getPlayerFleet,
        private readonly GetSithFleet    $getSithFleet,
        private readonly ProcessBattle   $processBattle,
    ) {
    }

    public function __invoke(): ProcessGameResponse
    {
        $this->createSithFleet->__invoke();
        $this->createUserFleet->__invoke();
        $result = $this->processBattle->__invoke(
            $this->getPlayerFleet->__invoke(),
            $this->getSithFleet->__invoke()
        );

        return new ProcessGameResponse(
            battleResult: $result
        );
    }
}
