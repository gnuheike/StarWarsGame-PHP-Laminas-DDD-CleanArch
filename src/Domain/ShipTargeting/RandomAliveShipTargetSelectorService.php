<?php

declare(strict_types=1);

namespace StarWars\Domain\ShipTargeting;

use InvalidArgumentException;
use StarWars\Domain\FleetCombat\ShipTargetSelectorServiceInterface;
use StarWars\Domain\Ship\Ship;

class RandomAliveShipTargetSelectorService implements ShipTargetSelectorServiceInterface
{
    /**
     * @param Ship[] $ships
     */
    public function getShipFromArray(array $ships): Ship
    {
        foreach ($ships as $ship) {
            if (!$ship instanceof Ship) {
                throw new InvalidArgumentException('Ships must be an array of Ship instances');
            }
        }

        $aliveShips = $this->getAliveShips($ships);
        return $aliveShips[array_rand($aliveShips)];
    }

    /**
     * @param Ship[] $ships
     */
    private function getAliveShips(array $ships): array
    {
        return array_filter(
            $ships,
            static fn (Ship $ship) => !$ship->isDestroyed()
        );
    }
}
