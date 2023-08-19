<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use InvalidArgumentException;

class ShipWeaponSystem
{
    /**
     * @param ShipWeapon[] $weapons
     * @throws InvalidArgumentException If the $weapons array contains anything other than ShipWeapon instances.
     */
    public function __construct(private readonly array $weapons)
    {
        foreach ($weapons as $weapon) {
            if (!$weapon instanceof ShipWeapon) {
                throw new InvalidArgumentException('Weapons must be an array of ShipWeapon instances');
            }
        }
    }

    /**
     * @return ShipWeapon[]
     */
    public function getAllWeapons(): array
    {
        return $this->weapons;
    }
}
