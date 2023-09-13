<?php

declare(strict_types=1);

namespace StarWars\Application\UseCase\CreateSithFleet;

use StarWars\Domain\Ship\ShipProviderInterface;

class SithFleetGenerator
{
    public function __construct(private readonly ShipProviderInterface $shipsProvider)
    {
    }

    public function generateShips(int $count): array
    {
        $ships = $this->shipsProvider->getShips();

        $return = [];
        for ($i = 0; $i < $count; $i++) {
            $return[] = $ships[array_rand($ships)];
        }
        return $return;
    }
}
