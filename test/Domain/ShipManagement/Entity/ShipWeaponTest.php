<?php

declare(strict_types=1);

namespace Test\Domain\ShipManagement\Entity;

use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\ShipWeapon;
use StarWars\Domain\Ship\ShipWeaponDamage;

class ShipWeaponTest extends TestCase
{
    public function testGetWeaponDamage(): void
    {
        $weaponDamage = new ShipWeaponDamage(10, 20);

        $shipWeapon = new ShipWeapon(
            'name',
            10,
            $weaponDamage
        );
        $this->assertSame($weaponDamage, $shipWeapon->getWeaponDamage());
    }
}
