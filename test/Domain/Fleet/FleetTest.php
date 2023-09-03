<?php

namespace Test\Domain\Fleet;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Ship\Ship;

class FleetTest extends TestCase
{
    private $fleet;
    private $ships;

    public function testConstructorWithInvalidShips(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Ships must be an array of ShipManagement instances');

        new Fleet(['invalid ship']);
    }

    public function testGetShips(): void
    {
        $this->assertSame($this->ships, $this->fleet->getShips());
    }

    public function testIsAlive(): void
    {
        foreach ($this->ships as $ship) {
            $ship->method('isDestroyed')->willReturn(false);
        }

        $this->assertTrue($this->fleet->isAlive());
    }

    public function testIsNotAlive(): void
    {
        foreach ($this->ships as $ship) {
            $ship->method('isDestroyed')->willReturn(true);
        }

        $this->assertFalse($this->fleet->isAlive());
    }

    protected function setUp(): void
    {
        $ships = [];
        for ($i = 0; $i < random_int(1, 100); $i++) {
            $ships[] = $this->createMock(Ship::class);
        }
        $this->ships = $ships;

        $this->fleet = new Fleet($this->ships);
    }
}
