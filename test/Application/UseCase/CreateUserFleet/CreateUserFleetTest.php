<?php

namespace Test\Application\UseCase\CreateUserFleet;

use PHPUnit\Framework\TestCase;
use StarWars\Application\Factory\FleetFactory;
use StarWars\Application\UseCase\CreateUserFleet\CreateUserFleet;
use StarWars\Application\UseCase\CreateUserFleet\ShipSelectorInterface;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipProviderInterface;

class CreateUserFleetTest extends TestCase
{
    public function testFleetCreated(): void
    {
        $ship = $this->createMock(Ship::class);

        $shipsRepositoryMock = $this->createMock(ShipProviderInterface::class);
        $shipsRepositoryMock->expects($this->once())
            ->method('getShips')
            ->willReturn([$ship]);

        $selectorMock = $this->createMock(ShipSelectorInterface::class);
        $selectorMock->expects($this->exactly(2))
            ->method('selectShip')
            ->willReturnOnConsecutiveCalls($ship, null);


        $useCase = new CreateUserFleet($shipsRepositoryMock, $selectorMock, new FleetFactory());
        $useCase->__invoke();
    }

}
