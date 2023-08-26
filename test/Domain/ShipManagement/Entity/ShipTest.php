<?php

namespace Test\Domain\ShipManagement\Entity;

use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipArmor;
use StarWars\Domain\Ship\ShipCost;
use StarWars\Domain\Ship\ShipName;
use StarWars\Domain\Ship\ShipShields;
use StarWars\Domain\Ship\ShipTargeting\RandomAliveShipTargetSelector;
use StarWars\Domain\Ship\ShipWeapon;
use StarWars\Domain\Ship\ShipWeaponSystem;


class ShipTest extends TestCase
{
    private Ship $ship;
    private ShipName $shipName;
    private ShipArmor $shipArmor;
    private ShipShields $shipShields;
    private ShipWeaponSystem $weapons;
    private ShipWeapon $shipWeapon;
    private ShipCost $shipCost;

    private RandomAliveShipTargetSelector $targetSelector;

    public function testIsDestroyed(): void
    {
        $this->shipArmor->method('isDepleted')->willReturn(true);
        $this->assertTrue($this->ship->isDestroyed());
    }

    public function testIsShieldsDepleted(): void
    {
        $this->shipShields->method('isDepleted')->willReturn(true);
        $this->assertTrue($this->ship->isShieldsDepleted());
    }

    public function testReceiveShieldsDamage(): void
    {
        $damage = 10;
        $this->shipShields->expects($this->once())
            ->method('receiveDamage')
            ->with($damage)
            ->willReturn($damage);

        $this->assertEquals($damage, $this->ship->receiveShieldsDamage($damage));
    }

    public function testReceiveArmorDamage(): void
    {
        $damage = 10;
        $this->shipArmor->expects($this->once())
            ->method('receiveDamage')
            ->with($damage)
            ->willReturn($damage);

        $this->assertEquals($damage, $this->ship->receiveArmorDamage($damage));
    }

    public function testReturnsWeapons(): void
    {
        $this->assertEquals($this->weapons, $this->ship->getWeaponSystem());
    }

    protected function setUp(): void
    {
        $this->shipName = $this->createMock(ShipName::class);
        $this->shipArmor = $this->createMock(ShipArmor::class);
        $this->shipShields = $this->createMock(ShipShields::class);
        $this->weapons = $this->createMock(ShipWeaponSystem::class);
        $this->shipWeapon = $this->createMock(ShipWeapon::class);
        $this->shipCost = $this->createMock(ShipCost::class);
        $this->targetSelector = $this->createMock(RandomAliveShipTargetSelector::class);

        $this->ship = new Ship(
            $this->shipName,
            $this->shipArmor,
            $this->shipShields,
            $this->weapons,
            $this->shipCost,
            $this->targetSelector
        );
    }
}
