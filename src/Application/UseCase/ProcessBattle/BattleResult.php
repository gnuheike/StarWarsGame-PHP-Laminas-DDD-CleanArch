<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\ProcessBattle;

use InvalidArgumentException;
use StarWars\Domain\Fleet\ShipInterface;

class BattleResult
{
    private int $steps;
    private BattleFleetEnum $winner;

    /**
     * @param ShipInterface[] $playerShips
     * @param ShipInterface[] $sithShips
     */
    public function __construct(
        private readonly array $playerShips,
        private readonly array $sithShips,
    ) {
        foreach (array_merge($this->playerShips, $this->sithShips) as $ship) {
            if (!$ship instanceof ShipInterface) {
                throw new InvalidArgumentException('Invalid ship type');
            }
        }

        $this->steps = 0;
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
        return $this->steps;
    }

    public function incrementSteps(): void
    {
        $this->steps++;
    }

    public function setWinner(BattleFleetEnum $winner): void
    {
        $this->winner = $winner;
    }

    public function getWinner(): BattleFleetEnum
    {
        return $this->winner;
    }
}
