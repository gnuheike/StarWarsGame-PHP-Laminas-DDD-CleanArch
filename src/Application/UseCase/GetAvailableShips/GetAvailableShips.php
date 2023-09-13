<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\GetAvailableShips;

use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipProviderInterface;

final class GetAvailableShips
{
    public function __construct(private readonly ShipProviderInterface $shipRepository)
    {
    }

    /**
     * @return Ship[]
     */
    public function __invoke(): array
    {
        return $this->shipRepository->getShips();
    }
}
