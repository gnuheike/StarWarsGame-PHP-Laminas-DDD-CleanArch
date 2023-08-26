<?php

namespace StarWars\Domain\Fleet;


interface FleetFactoryInterface
{
    /**
     * @param ShipInterface[] $ships
     * @return Fleet
     */
    public function createFleet(array $ships): Fleet;
}
