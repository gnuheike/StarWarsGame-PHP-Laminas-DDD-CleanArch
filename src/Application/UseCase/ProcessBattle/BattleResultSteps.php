<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessBattle;

class BattleResultSteps
{
    public function __construct(
        private int $steps
    ) {
    }

    public function getSteps(): int
    {
        return $this->steps;
    }

    public function incrementSteps(): void
    {
        $this->steps++;
    }
}
