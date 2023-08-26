<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\GetSithFleet;

use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Fleet\FleetFactoryInterface;
use StarWars\Domain\Repository\ShipRepositoryInterface;

class GetSithFleet
{
    public function __construct(
        private readonly ShipRepositoryInterface $sithFleetRepository,
        private readonly FleetFactoryInterface   $fleetFactory,
    ) {
    }

    public function __invoke(): Fleet
    {
        return $this->fleetFactory->createFleet(
            $this->sithFleetRepository->getAllShips()
        );
    }
}
