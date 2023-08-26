<?php

namespace Test\Application\UseCase\ProcessBattle;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\ProcessBattle\BattleFactoryInterface;
use StarWars\Application\UseCase\ProcessBattle\BattleFleetEnum;
use StarWars\Application\UseCase\ProcessBattle\ProcessBattle;
use StarWars\Domain\Battle\Battle;
use StarWars\Domain\Fleet\Fleet;

class ProcessBattleTest extends TestCase
{
    public function testProcessBattle(): void
    {
        $fleet1 = $this->createMock(Fleet::class);
        $fleet2 = $this->createMock(Fleet::class);
        $battleFactory = $this->createMock(BattleFactoryInterface::class);
        $battle = $this->createMock(Battle::class);

        $battleFactory->expects($this->once())
            ->method('createBattle')
            ->with($fleet1, $fleet2)
            ->willReturn($battle);

        $battle->expects($this->once())
            ->method('engage')
            ->willReturn([true, true, true]);


        $fleet1->expects($this->once())
            ->method('isAlive')
            ->willReturn(true);

        $processBattle = new ProcessBattle($battleFactory);
        $battleResult = $processBattle($fleet1, $fleet2);

        $this->assertEquals(BattleFleetEnum::PLAYER_FLEET, $battleResult->getWinner());
    }
}
