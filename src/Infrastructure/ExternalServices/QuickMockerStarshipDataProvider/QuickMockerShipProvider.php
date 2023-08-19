<?php

declare(strict_types=1);

namespace StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider;

use StarWars\Domain\Repository\ShipsProviderInterface;

final class QuickMockerShipProvider implements ShipsProviderInterface
{
    public function __construct(
        private readonly QuickMockerClient     $client,
        private readonly QuickMockerShipMapper $mapper
    ) {
    }

    public function getShips(): array
    {
        return array_map(
            $this->mapper->mapArrayToShip(...),
            $this->client->getShips()
        );
    }
}
