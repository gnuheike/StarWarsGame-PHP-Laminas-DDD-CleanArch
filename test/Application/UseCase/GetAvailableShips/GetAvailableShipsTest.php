<?php

namespace Test\Application\UseCase\GetAvailableShips;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\GetAvailableShips\GetAvailableShips;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipProviderInterface;

class GetAvailableShipsTest extends TestCase
{
    private GetAvailableShips $useCase;
    private ShipProviderInterface $shipRepository;

    public function setUp(): void
    {
        $this->shipRepository = $this->createMock(ShipProviderInterface::class);
        $this->useCase = new GetAvailableShips($this->shipRepository);
    }

    public function testItShouldReturnListOfShipsWhenThereAreShipsAvailable(): void
    {
        $ships = [
            $this->createMock(Ship::class),
            $this->createMock(Ship::class),
        ];

        $this->shipRepository->expects($this->once())
            ->method('getShips')
            ->willReturn($ships);

        $this->assertEquals($ships, $this->useCase->__invoke());
    }

    public function testItShouldReturnEmptyArrayWhenThereAreNoShips(): void
    {
        $this->shipRepository->expects($this->once())
            ->method('getShips')
            ->willReturn([]);

        $this->assertEmpty($this->useCase->__invoke());
    }
}
