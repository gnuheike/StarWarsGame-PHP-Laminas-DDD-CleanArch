<?php

namespace Test\Application\UseCase\CreateUserFleet;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\CreateUserFleet\CreateUserFleet;
use StarWars\Application\UseCase\CreateUserFleet\ShipSelectorInterface;
use StarWars\Domain\Fleet\ShipInterface;
use StarWars\Domain\Repository\ShipRepositoryInterface;
use StarWars\Domain\Repository\ShipsProviderInterface;

class CreateUserFleetTest extends TestCase
{
    public function testFleetCreated(): void
    {
        $ship = $this->createMock(ShipInterface::class);

        $shipsRepositoryMock = $this->createMock(ShipsProviderInterface::class);
        $shipsRepositoryMock->expects($this->once())
            ->method('getShips')
            ->willReturn([$ship]);

        $selectorMock = $this->createMock(ShipSelectorInterface::class);
        $selectorMock->expects($this->exactly(2))
            ->method('selectShip')
            ->willReturnOnConsecutiveCalls($ship, null);

        $userShipsRepositoryMock = $this->createMock(ShipRepositoryInterface::class);
        $userShipsRepositoryMock->expects($this->once())
            ->method('addShip')
            ->with($ship);

        $useCase = new CreateUserFleet($shipsRepositoryMock, $selectorMock, $userShipsRepositoryMock);
        $useCase->__invoke();
    }

}
