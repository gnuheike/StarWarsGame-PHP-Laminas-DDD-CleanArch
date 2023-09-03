<?php

namespace StarWars\Domain\Ship;

interface ShipProviderInterface
{
    /**
     * @return Ship[]
     */
    public function getShips(): array;
}
