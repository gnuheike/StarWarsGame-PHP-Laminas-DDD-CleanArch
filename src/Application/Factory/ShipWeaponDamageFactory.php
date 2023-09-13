<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\ShipWeaponDamage;

class ShipWeaponDamageFactory
{
    public function createShipWeaponDamage(
        int $minDamage,
        int $maxDamage
    ): ShipWeaponDamage {
        return new ShipWeaponDamage(
            min: $minDamage,
            max: $maxDamage
        );
    }
}
