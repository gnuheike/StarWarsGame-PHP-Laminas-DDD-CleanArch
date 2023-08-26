<?php

namespace StarWars\Domain\Repository;

use StarWars\Domain\Ship\Ship;

interface ShipRepositoryInterface
{
    /**
     * @return Ship[]
     */
    public function getAllShips(): array;

    public function addShip(Ship $ship): void;
}
