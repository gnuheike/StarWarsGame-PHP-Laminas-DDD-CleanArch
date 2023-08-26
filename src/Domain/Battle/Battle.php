<?php

declare(strict_types=1);

namespace StarWars\Domain\Battle;

use StarWars\Domain\Fleet\Fleet;

class Battle
{
    public function __construct(
        private readonly Fleet $fleet1,
        private readonly Fleet $fleet2
    ) {
    }

    /**
     * @return iterable<bool>
     */
    public function engage(): iterable
    {
        while ($this->fleet1->isAlive() && $this->fleet2->isAlive()) {
            $this->engageFleets($this->fleet1, $this->fleet2);

            if (!$this->fleet2->isAlive()) {
                break;
            }

            $this->engageFleets($this->fleet2, $this->fleet1);

            yield true;
        }
    }

    private function engageFleets(Fleet $attackingFleet, Fleet $defendingFleet): void
    {
        foreach ($attackingFleet->getShips() as $ship) {
            if (!$defendingFleet->isAlive()) {
                break;
            }

            $ship->fireToFleet($defendingFleet);
        }
    }
}
