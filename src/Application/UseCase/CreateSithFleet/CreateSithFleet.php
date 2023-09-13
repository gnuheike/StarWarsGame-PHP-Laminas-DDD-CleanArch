<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\CreateSithFleet;

use StarWars\Application\Factory\FleetFactory;
use StarWars\Domain\Fleet\Fleet;

class CreateSithFleet
{
    public function __construct(
        private readonly SithFleetGenerator $sithFleetGenerator,
        private readonly FleetFactory $fleetFactory,
        private readonly int $sithFleetSize
    ) {
    }

    public function __invoke(): Fleet
    {
        $ships = $this->sithFleetGenerator->generateShips($this->sithFleetSize);
        return $this->fleetFactory->createFleet($ships);
    }
}
