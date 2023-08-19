<?php

namespace Test\Domain\ShipTargeting\Service;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\ShipTargeting\RandomAliveShipTargetSelectorService;

class RandomAliveShipTargetSelectorTest extends TestCase
{
    private RandomAliveShipTargetSelectorService $randomAliveShipTargetSelector;

    protected function setUp(): void
    {
        $this->randomAliveShipTargetSelector = new RandomAliveShipTargetSelectorService();
    }

    public function testGetShipFromArray(): void
    {
        $ship1 = $this->createMock(Ship::class);
        $ship2 = $this->createMock(Ship::class);
        $ship3 = $this->createMock(Ship::class);

        $ship1->method('isDestroyed')->willReturn(false);
        $ship2->method('isDestroyed')->willReturn(true);
        $ship3->method('isDestroyed')->willReturn(false);

        $ships = [$ship1, $ship2, $ship3];
        $aliveShip = $this->randomAliveShipTargetSelector->getShipFromArray($ships);

        $this->assertInstanceOf(Ship::class, $aliveShip);
        $this->assertFalse($aliveShip->isDestroyed());
    }

    public function testGetShipFromArrayThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->randomAliveShipTargetSelector->getShipFromArray(['qwe']);
    }
}
