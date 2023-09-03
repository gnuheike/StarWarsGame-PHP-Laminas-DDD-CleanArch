<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\CreateUserFleet;

use StarWars\Application\Factory\FleetFactory;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Ship\ShipProviderInterface;

class CreateUserFleet
{
    public function __construct(
        private readonly ShipProviderInterface $shipsRepository,
        private readonly ShipSelectorInterface $shipSelector,
        private readonly FleetFactory $fleetFactory,
    ) {
    }

    public function __invoke(): Fleet
    {
        $availableShips = $this->shipsRepository->getShips();

        $selectedShips = [];
        while ($ship = $this->shipSelector->selectShip($availableShips)) {
            $selectedShips[] = $ship;
        }

        return $this->fleetFactory->createFleet($selectedShips);
    }
}
