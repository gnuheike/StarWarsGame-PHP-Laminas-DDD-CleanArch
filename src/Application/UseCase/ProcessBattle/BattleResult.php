<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessBattle;

use InvalidArgumentException;
use StarWars\Domain\Ship\Ship;

class BattleResult
{
    private BattleResultSteps $steps;
    private BattleFleetEnum $winner;

    /**
     * @param Ship[] $playerShips
     * @param Ship[] $sithShips
     */
    public function __construct(
        private readonly array $playerShips,
        private readonly array $sithShips,
    ) {
        foreach (array_merge($this->playerShips, $this->sithShips) as $ship) {
            if (!$ship instanceof Ship) {
                throw new InvalidArgumentException('Invalid ship type');
            }
        }

        $this->steps = new BattleResultSteps(0);
    }

    public function getPlayerShips(): array
    {
        return $this->playerShips;
    }

    public function getSithShips(): array
    {
        return $this->sithShips;
    }

    public function getSteps(): int
    {
        return $this->steps->getSteps();
    }

    public function incrementSteps(): void
    {
        $this->steps->incrementSteps();
    }

    public function getWinner(): BattleFleetEnum
    {
        return $this->winner;
    }

    public function setWinner(BattleFleetEnum $winner): void
    {
        $this->winner = $winner;
    }
}
