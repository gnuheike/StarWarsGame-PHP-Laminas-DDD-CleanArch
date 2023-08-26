<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Fleet\FleetFactoryInterface;

class FleetFactory implements FleetFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createFleet(array $ships): Fleet
    {
        return new Fleet($ships);
    }
}
