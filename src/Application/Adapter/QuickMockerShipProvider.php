<?php

declare(strict_types=1);

namespace StarWars\Application\Adapter;

use StarWars\Application\Factory\QuickMockerShipFactory;
use StarWars\Domain\Ship\ShipProviderInterface;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerClient;

final class QuickMockerShipProvider implements ShipProviderInterface
{
    public function __construct(
        private readonly QuickMockerClient $client,
        private readonly QuickMockerShipFactory $mapper
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
