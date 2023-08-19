<?php
declare(strict_types=1);


namespace Test\Domain\ShipManagement\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\ShipWeaponDamage;
use TypeError;

class ShipWeaponDamageTest extends TestCase
{
    public function testGetWeaponDamageReturnsRandomNumberBetweenMinAndMax(): void
    {
        $weapon = new ShipWeaponDamage(1, 10);
        $damage = $weapon->getDamageValue();
        $this->assertGreaterThanOrEqual(1, $damage);
        $this->assertLessThanOrEqual(10, $damage);
    }

    public function testGetWeaponDamageThrowsExceptionIfMinIsGreaterThanMax(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Min must be less than or equal to max');
        new ShipWeaponDamage(10, 1);
    }

    public function testGetWeaponDamageThrowsExceptionIfMinIsLessThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Min must be greater than or equal to zero');
        new ShipWeaponDamage(-1, 1);
    }

    public function testGetWeaponDamageThrowsExceptionIfMaxIsLessThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Max must be greater than or equal to zero');
        new ShipWeaponDamage(1, -1);
    }

    public function testGetWeaponDamageThrowsExceptionIfMinIsNotAnInteger(): void
    {
        $this->expectException(TypeError::class);
        new ShipWeaponDamage(1.1, 1);
    }

    public function testGetWeaponDamageThrowsExceptionIfMaxIsNotAnInteger(): void
    {
        $this->expectException(TypeError::class);
        new ShipWeaponDamage(1, 1.1);
    }

    public function testMaximumNumbers(): void
    {
        $weapon = new ShipWeaponDamage(PHP_INT_MAX, PHP_INT_MAX);
        $damage = $weapon->getDamageValue();
        $this->assertEquals(PHP_INT_MAX, $damage);
    }
}
