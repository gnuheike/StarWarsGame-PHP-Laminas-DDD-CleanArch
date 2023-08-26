<?php

declare(strict_types=1);

namespace StarWars\Domain\FleetCombat;

use StarWars\Domain\Battle\FleetCombatServiceInterface;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\ShipDamageControl\Service\ShipDamageProcessor;
use StarWars\Domain\ShipTargeting\RandomAliveShipTargetSelector;

class FleetCombatService implements FleetCombatServiceInterface
{
    public function __construct(
        private readonly RandomAliveShipTargetSelector $fireTargetSelector,
        private readonly ShipDamageProcessor $damageCalculation
    ) {
    }

    public function engage(Fleet $attackingFleet, Fleet $defendingFleet): void
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
