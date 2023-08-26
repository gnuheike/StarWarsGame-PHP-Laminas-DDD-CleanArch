<?php

namespace StarWars\Application\UseCase\StoreBattleResult;

use StarWars\Application\UseCase\ProcessBattle\BattleResult;

interface BattleResultRepository
{
    public function store(BattleResult $result): void;

    public function getResults(): array;
}
