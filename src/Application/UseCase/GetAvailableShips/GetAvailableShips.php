<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\GetAvailableShips;

use StarWars\Domain\Fleet\ShipInterface;
use StarWars\Domain\Repository\ShipsProviderInterface;

final class GetAvailableShips
{
    public function __construct(private readonly ShipsProviderInterface $shipRepository)
    {
    }

    /**
     * @return ShipInterface[]
     */
    public function __invoke(): array
    {
        return $this->shipRepository->getShips();
    }
}
