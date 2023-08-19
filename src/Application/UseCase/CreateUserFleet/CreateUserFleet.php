<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\CreateUserFleet;

use StarWars\Domain\Repository\ShipRepositoryInterface;
use StarWars\Domain\Repository\ShipsProviderInterface;

class CreateUserFleet
{
    public function __construct(
        private readonly ShipsProviderInterface  $shipsRepository,
        private readonly ShipSelectorInterface   $shipSelector,
        private readonly ShipRepositoryInterface $userShipsRepository
    ) {
    }

    public function __invoke(): void
    {
        $ships = $this->shipsRepository->getShips();

        while ($ship = $this->shipSelector->selectShip($ships)) {
            $this->userShipsRepository->addShip($ship);
        }
    }
}
