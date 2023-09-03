<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\ShipWeaponSystem;

class ShipWeaponSystemFactory
{
    public function __construct(private readonly ShipWeaponFactory $shipWeaponFactory)
    {
    }

    public function createShipWeaponSystem(array $weaponSystem): ShipWeaponSystem
    {
        return new ShipWeaponSystem(
            weapons: array_map(
                fn (array $weapon) => $this->shipWeaponFactory->createShipWeapon(
                    name: $weapon['name'],
                    amount: $weapon['amount'],
                    minDamage: $weapon['minDamage'],
                    maxDamage: $weapon['maxDamage']
                ),
                $weaponSystem
            )
        );
    }
}
