<?php

declare(strict_types=1);

namespace StarWars\Domain\Fleet;

use InvalidArgumentException;
use StarWars\Domain\Ship\Ship;

class Fleet
{
    /**
     * @param Ship[] $ships
     * @throws InvalidArgumentException if the $ships array contains elements that are not instances of the ShipManagement class.
     */
    public function __construct(private readonly array $ships)
    {
        foreach ($ships as $ship) {
            if (!$ship instanceof Ship) {
                throw new InvalidArgumentException('Ships must be an array of ShipManagement instances');
            }
        }
    }

    public function getShips(): array
    {
        return $this->ships;
    }

    public function isAlive(): bool
    {
        foreach ($this->ships as $ship) {
            if (!$ship->isDestroyed()) {
                return true;
            }
        }
        return false;
    }
}
