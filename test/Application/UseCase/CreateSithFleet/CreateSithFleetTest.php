<?php
declare(strict_types=1);


namespace Test\Application\UseCase\CreateSithFleet;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\CreateSithFleet\CreateSithFleet;
use StarWars\Application\UseCase\CreateSithFleet\SithFleetGeneratorInterface;
use StarWars\Domain\Repository\ShipRepositoryInterface;
use StarWars\Domain\Ship\Ship;

final class CreateSithFleetTest extends TestCase
{
    public function testCreateSithFleet(): void
    {
        $ships = [
            $this->createMock(Ship::class),
            $this->createMock(Ship::class),
            $this->createMock(Ship::class),
            $this->createMock(Ship::class),
        ];

        $generatorMock = $this->createMock(SithFleetGeneratorInterface::class);
        $generatorMock->expects($this->once())
            ->method('generateShips')
            ->willReturn($ships);

        $repoMock = $this->createMock(ShipRepositoryInterface::class);

        $matcher = $this->exactly(count($ships));
        $repoMock->expects($matcher)
            ->method('addShip')
            ->willReturnCallback(
                fn(Ship $ship) => $this->assertEquals($ships[$matcher->hasBeenInvoked()], $ship)
            );


        $useCase = new CreateSithFleet($generatorMock, $repoMock, 100);
        $useCase->__invoke();
    }
}