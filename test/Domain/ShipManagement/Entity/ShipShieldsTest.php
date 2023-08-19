<?php

declare(strict_types=1);


namespace Test\Domain\ShipManagement\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\ShipShields;

class ShipShieldsTest extends TestCase
{
    public function testAllDamageAbsorbed(): void
    {
        $armor = new ShipShields(100);
        $extraDamage = $armor->receiveDamage(100);
        $this->assertEquals(0, $extraDamage);
    }

    public function testSomeDamageAbsorbed(): void
    {
        $armor = new ShipShields(100);
        $extraDamage = $armor->receiveDamage(50);
        $this->assertEquals(0, $extraDamage);
    }

    public function testMoreDamageThanArmor(): void
    {
        $armor = new ShipShields(100);
        $extraDamage = $armor->receiveDamage(150);
        $this->assertEquals(50, $extraDamage);
    }

    public function testNegativeArmor(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $armor = new ShipShields(-100);
        $armor->receiveDamage(150);
    }

    public function testMaximumNumber(): void
    {
        $armor = new ShipShields(PHP_INT_MAX);
        $extraDamage = $armor->receiveDamage(PHP_INT_MAX);
        $this->assertEquals(0, $extraDamage);
    }


    public function testIsDepleted(): void
    {
        $shields = new ShipShields(100);
        $shields->receiveDamage(100);
        $this->assertTrue($shields->isDepleted());
    }

    public function testIsNotDepleted(): void
    {
        $shields = new ShipShields(100);
        $shields->receiveDamage(50);
        $this->assertFalse($shields->isDepleted());
    }
}
