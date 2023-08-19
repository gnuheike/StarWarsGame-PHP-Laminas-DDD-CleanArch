<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\StoreBattleResult;

use StarWars\Application\UseCase\ProcessBattle\BattleResult;

class StoreBattleResult
{
    public function __construct(private readonly BattleResultRepositoryInterface $battleResultRepository)
    {
    }

    public function __invoke(BattleResult $result): void
    {
        $this->battleResultRepository->store($result);
    }
}
