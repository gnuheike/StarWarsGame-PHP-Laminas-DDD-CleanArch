<?php

namespace Test\Application\UseCase\ProcessGame;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\CreateSithFleet\CreateSithFleet;
use StarWars\Application\UseCase\CreateUserFleet\CreateUserFleet;
use StarWars\Application\UseCase\GetPlayerFleet\GetPlayerFleet;
use StarWars\Application\UseCase\GetSithFleet\GetSithFleet;
use StarWars\Application\UseCase\ProcessBattle\ProcessBattle;
use StarWars\Application\UseCase\ProcessGame\ProcessGame;
use StarWars\Application\UseCase\ProcessGame\ProcessGameResponse;

class ProcessGameTest extends TestCase
{

    public function testProcessGame(): void
    {
        $createSithFleet = $this->createMock(CreateSithFleet::class);
        $createUserFleet = $this->createMock(CreateUserFleet::class);
        $getPlayerFleet = $this->createMock(GetPlayerFleet::class);
        $getSithFleet = $this->createMock(GetSithFleet::class);
        $processBattle = $this->createMock(ProcessBattle::class);

        $processGame = new ProcessGame(
            $createSithFleet,
            $createUserFleet,
            $getPlayerFleet,
            $getSithFleet,
            $processBattle
        );

        $createSithFleet->expects($this->once())
            ->method('__invoke');
        $createUserFleet->expects($this->once())
            ->method('__invoke');
        $processBattle->expects($this->once())
            ->method('__invoke');

        $result = $processGame->__invoke();
        $this->assertInstanceOf(ProcessGameResponse::class, $result);
    }

}
