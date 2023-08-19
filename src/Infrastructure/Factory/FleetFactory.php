<?php

declare(strict_types=1);

namespace StarWars\Infrastructure\Factory;

use StarWars\Domain\Battle\FleetInterface;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Fleet\FleetFactoryInterface;

final class FleetFactory implements FleetFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createFleet(array $ships): FleetInterface
    {
        return new Fleet($ships);
    }
}
