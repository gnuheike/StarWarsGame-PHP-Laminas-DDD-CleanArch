<?php

declare(strict_types=1);


namespace Test\Application\UseCase\CreateSithFleet;

use PHPUnit\Framework\TestCase;
use StarWars\Application\Factory\FleetFactory;
use StarWars\Application\UseCase\CreateSithFleet\CreateSithFleet;
use StarWars\Application\UseCase\CreateSithFleet\SithFleetGenerator;
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

        $generatorMock = $this->createMock(SithFleetGenerator::class);
        $generatorMock->expects($this->once())
            ->method('generateShips')
            ->willReturn($ships);

        $useCase = new CreateSithFleet($generatorMock, new FleetFactory(), 100);
        $useCase->__invoke();
    }
}