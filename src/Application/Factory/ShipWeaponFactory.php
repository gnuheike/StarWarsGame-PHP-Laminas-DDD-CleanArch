<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\ShipWeapon;

class ShipWeaponFactory
{
    public function __construct(private readonly ShipWeaponDamageFactory $weaponDamageFactory)
    {
    }

    public function createShipWeapon(
        string $name,
        int $amount,
        int $minDamage,
        int $maxDamage
    ): ShipWeapon {
        return new ShipWeapon(
            name: $name,
            amount: $amount,
            damage: $this->weaponDamageFactory->createShipWeaponDamage(
                minDamage: $minDamage,
                maxDamage: $maxDamage
            )
        );
    }
}
