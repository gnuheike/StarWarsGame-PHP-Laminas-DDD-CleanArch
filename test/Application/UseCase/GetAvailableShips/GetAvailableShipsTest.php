<?php

namespace Test\Application\UseCase\GetAvailableShips;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\GetAvailableShips\GetAvailableShips;
use StarWars\Domain\Repository\ShipsProviderInterface;
use StarWars\Domain\Ship\Ship;

class GetAvailableShipsTest extends TestCase
{
    private GetAvailableShips $useCase;
    private ShipsProviderInterface $shipRepository;

    public function setUp(): void
    {
        $this->shipRepository = $this->createMock(ShipsProviderInterface::class);
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
