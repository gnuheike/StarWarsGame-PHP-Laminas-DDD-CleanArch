<?php
declare(strict_types=1);


namespace Test\Domain\ShipManagement\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\ShipWeapon;
use StarWars\Domain\Ship\ShipWeaponDamage;
use StarWars\Domain\Ship\ShipWeaponSystem;
use TypeError;

class ShipWeaponsTest extends TestCase
{
    /** @noinspection PhpUnhandledExceptionInspection */
    private function getWeapon(): ShipWeapon
    {
        $min = random_int(0, PHP_INT_MAX - 1);
        $max = random_int($min, PHP_INT_MAX);
        $damage = new ShipWeaponDamage($min, $max);

        return new ShipWeapon(
            'name',
            10,
            $damage
        );
    }

    public function testAcceptAndReturnValidShips(): void
    {
        $weaponsArray = [
            $this->getWeapon(),
            $this->getWeapon()
        ];

        $weapons = new ShipWeaponSystem($weaponsArray);
        $this->assertEquals($weapons->getAllWeapons(), $weaponsArray);
    }

    public function testConstructorThrowsExceptionIfWeaponsIsNotAnArray(): void
    {
        $this->expectException(TypeError::class);
        new ShipWeaponSystem('not an array');
    }

    public function testConstructorThrowsExceptionIfSomeWeaponsAreNotShipWeapons(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ShipWeaponSystem(['not a ship weapon']);
    }
}
