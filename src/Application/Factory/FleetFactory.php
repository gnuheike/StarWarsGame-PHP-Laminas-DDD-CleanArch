<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Ship\Ship;

class FleetFactory
{
    /**
     * @param Ship[] $ships
     * @return Fleet
     */
    public function createFleet(array $ships): Fleet
    {
        return new Fleet($ships);
    }
}
