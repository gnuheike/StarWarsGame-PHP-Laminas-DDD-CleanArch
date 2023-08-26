<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\GetPlayerFleet;

use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Fleet\FleetFactoryInterface;
use StarWars\Domain\Repository\ShipRepositoryInterface;

class GetPlayerFleet
{
    public function __construct(
        private readonly ShipRepositoryInterface $playerShipsRepository,
        private readonly FleetFactoryInterface   $fleetFactory,
    ) {
    }

    public function __invoke(): Fleet
    {
        return $this->fleetFactory->createFleet(
            $this->playerShipsRepository->getAllShips()
        );
    }
}
