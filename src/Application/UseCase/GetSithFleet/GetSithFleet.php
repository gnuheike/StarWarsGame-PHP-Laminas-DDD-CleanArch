<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\GetSithFleet;

use StarWars\Domain\Battle\FleetInterface;
use StarWars\Domain\Fleet\FleetFactoryInterface;
use StarWars\Domain\Repository\ShipRepositoryInterface;

class GetSithFleet
{
    public function __construct(
        private readonly ShipRepositoryInterface $sithFleetRepository,
        private readonly FleetFactoryInterface   $fleetFactory,
    ) {
    }

    public function __invoke(): FleetInterface
    {
        return $this->fleetFactory->createFleet(
            $this->sithFleetRepository->getAllShips()
        );
    }
}
