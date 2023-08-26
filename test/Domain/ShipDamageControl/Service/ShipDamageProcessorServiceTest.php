<?php /** @noinspection ALL */

namespace Test\Domain\ShipDamageControl\Service;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipWeapon;
use StarWars\Domain\Ship\ShipWeaponDamage;
use StarWars\Domain\Ship\ShipWeaponSystem;
use StarWars\Domain\ShipDamageControl\Service\ShipDamageProcessor;

class ShipDamageProcessorServiceTest extends TestCase
{
    private ShipDamageProcessor $shipDamageProcessorService;

    protected function setUp(): void
    {
        $this->shipDamageProcessorService = new ShipDamageProcessor();
    }

    public function testProcessShipDamageToShip(): void
    {
        $shipDamageEmitter = $this->createMock(Ship::class);
        $shipWeaponSystem = $this->createMock(ShipWeaponSystem::class);
        $shipDamageEmitter->method('getWeaponSystem')->willReturn($shipWeaponSystem);

        $damageValue = random_int(1, 1000);
        $amount = random_int(1, 1000);
        $shipWeaponDamage = $this->createMock(ShipWeaponDamage::class);
        $shipWeaponDamage->method('getDamageValue')->willReturn($damageValue);

        $shipWeapon = new ShipWeapon('Test Weapon', $amount, $shipWeaponDamage);
        $shipWeaponSystem->method('getAllWeapons')->willReturn([$shipWeapon]);

        $shipDamageReceiver = $this->createMock(Ship::class);
        $shipDamageReceiver->method('isDestroyed')->willReturn(false);
        $shipDamageReceiver->method('isShieldsDepleted')->willReturn(false);
        $shipDamageReceiver->expects($this->once())
            ->method('receiveShieldsDamage')
            ->with($damageValue * $amount);

        $this->shipDamageProcessorService->processShipDamageToShip($shipDamageEmitter, $shipDamageReceiver);
    }

    public function testProcessShipDamageToDestroyedShip(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot damage a destroyed ship');

        $shipDamageEmitter = $this->createMock(Ship::class);
        $weapon = $this->createMock(ShipWeaponSystem::class);
        $weapons = [$this->createMock(ShipWeapon::class)];
        $weapon->method('getAllWeapons')->willReturn($weapons);
        $shipDamageEmitter->method('getWeaponSystem')->willReturn($weapon);

        $shipDamageReceiver = $this->createMock(Ship::class);

        $shipDamageReceiver->expects($this->once())
            ->method('isDestroyed')
            ->willReturn(true);

        $this->shipDamageProcessorService->processShipDamageToShip($shipDamageEmitter, $shipDamageReceiver);
    }
}
