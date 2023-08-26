<?php

namespace Test\Domain\Battle;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\ProcessBattle\BattleFleetEnum;
use StarWars\Application\UseCase\ProcessBattle\BattleResult;
use StarWars\Domain\Ship\Ship;
use stdClass;

class BattleResultTest extends TestCase
{
    public function testBattleResult(): void
    {
        $ships1 = [
            $this->createMock(Ship::class),
            $this->createMock(Ship::class)
        ];
        $ships2 = [
            $this->createMock(Ship::class),
            $this->createMock(Ship::class)
        ];
        $battleResult = new BattleResult($ships1, $ships2);

        $this->assertSame($ships1, $battleResult->getPlayerShips());
        $this->assertSame($ships2, $battleResult->getSithShips());
        $this->assertSame(0, $battleResult->getSteps());

        $battleResult->incrementSteps();
        $this->assertSame(1, $battleResult->getSteps());

        $battleResult->setWinner(BattleFleetEnum::PLAYER_FLEET);
        $this->assertSame(BattleFleetEnum::PLAYER_FLEET, $battleResult->getWinner());
    }

    public function testInvalidParameters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ship type');
        new BattleResult([new stdClass()], []);
    }
}
