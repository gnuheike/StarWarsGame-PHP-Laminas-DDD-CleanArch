<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\CreateSithFleet;

use StarWars\Domain\Repository\ShipRepositoryInterface;

class CreateSithFleet
{
    public function __construct(
        private readonly SithFleetGeneratorInterface $sithFleetGenerator,
        private readonly ShipRepositoryInterface     $sithFleetRepository,
        private readonly int                         $sithFleetSize
    ) {
    }

    public function __invoke(): void
    {
        $ships = $this->sithFleetGenerator->generateShips($this->sithFleetSize);

        foreach ($ships as $ship) {
            $this->sithFleetRepository->addShip($ship);
        }
    }
}
