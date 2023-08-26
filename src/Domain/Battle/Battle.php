<?php

declare(strict_types=1);

namespace StarWars\Domain\Battle;

use StarWars\Domain\Fleet\Fleet;

class Battle
{
    public function __construct(
        private readonly Fleet              $fleet1,
        private readonly Fleet              $fleet2,
        private readonly FleetCombatServiceInterface $fleetCombatService
    ) {
    }

    /**
     * @return iterable<bool>
     */
    public function engage(): iterable
    {
        while ($this->fleet1->isAlive() && $this->fleet2->isAlive()) {
            $this->fleetCombatService->engage($this->fleet1, $this->fleet2);
            if (!$this->fleet2->isAlive()) {
                break;
            }

            $this->fleetCombatService->engage($this->fleet2, $this->fleet1);

            yield true;
        }
    }
}
