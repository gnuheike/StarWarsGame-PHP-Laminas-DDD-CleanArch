<?php

namespace StarWars\Domain\Repository;

use StarWars\Domain\Fleet\ShipInterface;

interface ShipsProviderInterface
{
    /**
     * @return ShipInterface[]
     */
    public function getShips(): array;
}
