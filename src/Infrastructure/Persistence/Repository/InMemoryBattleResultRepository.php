<?php

declare(strict_types=1);

namespace StarWars\Infrastructure\Persistence\Repository;

use StarWars\Application\UseCase\ProcessBattle\BattleResult;
use StarWars\Application\UseCase\StoreBattleResult\BattleResultRepositoryInterface;

final class InMemoryBattleResultRepository implements BattleResultRepositoryInterface
{
    private array $results = [];

    public function store(BattleResult $result): void
    {
        $this->results[] = $result;
    }

    public function getResults(): array
    {
        return $this->results;
    }
}
