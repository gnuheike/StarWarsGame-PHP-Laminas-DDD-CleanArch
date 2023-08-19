<?php

namespace StarWars\Domain\Repository;

use StarWars\Domain\Fleet\ShipInterface;
use StarWars\Domain\Ship\Ship;

interface ShipRepositoryInterface
{
    /**
     * @return ShipInterface[]
     */
    public function getAllShips(): array;

    public function addShip(ShipInterface $ship): void;
}
