<?php

namespace StarWars\Application\UseCase\CreateSithFleet;

use StarWars\Domain\Fleet\ShipInterface;

interface SithFleetGeneratorInterface
{
    /**
     * @return ShipInterface[]
     */
    public function generateShips(int $count): array;
}
