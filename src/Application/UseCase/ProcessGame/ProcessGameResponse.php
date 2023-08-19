<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessGame;

use StarWars\Application\UseCase\ProcessBattle\BattleResult;

final class ProcessGameResponse
{
    public function __construct(public readonly BattleResult $battleResult)
    {
    }
}
