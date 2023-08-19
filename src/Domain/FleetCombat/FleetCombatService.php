<?php

declare(strict_types=1);

namespace StarWars\Domain\FleetCombat;

use StarWars\Domain\Battle\FleetCombatServiceInterface;
use StarWars\Domain\Battle\FleetInterface;
use StarWars\Domain\Ship\Ship;

class FleetCombatService implements FleetCombatServiceInterface
{
    public function __construct(
        private readonly ShipTargetSelectorServiceInterface  $fireTargetSelector,
        private readonly ShipDamageProcessorServiceInterface $damageCalculation
    ) {
    }

    public function engage(FleetInterface $attackingFleet, FleetInterface $defendingFleet): void
    {
        foreach ($attackingFleet->getShips() as $ship) {
            if (!$defendingFleet->isAlive()) {
                break;
            }
            $this->fireToShips($ship, $defendingFleet->getShips());
        }
    }

    private function fireToShips(Ship $ship, array $ships): void
    {
        $targetShip = $this->fireTargetSelector->getShipFromArray($ships);
        $this->damageCalculation->processShipDamageToShip($ship, $targetShip);
    }
}
