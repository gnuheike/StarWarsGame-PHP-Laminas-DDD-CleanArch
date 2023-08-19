<?php

namespace StarWars\Application\UseCase\StoreBattleResult;

use StarWars\Application\UseCase\ProcessBattle\BattleResult;

interface BattleResultRepositoryInterface
{
    public function store(BattleResult $result): void;

    public function getResults(): array;
}
