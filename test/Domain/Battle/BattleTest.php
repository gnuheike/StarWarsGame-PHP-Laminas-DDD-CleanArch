<?php

namespace Test\Domain\Battle;

use Exception;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Battle\Battle;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\FleetCombat\FleetCombatService;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipArmor;
use StarWars\Domain\Ship\ShipCost;
use StarWars\Domain\Ship\ShipName;
use StarWars\Domain\Ship\ShipShields;
use StarWars\Domain\Ship\ShipWeapon;
use StarWars\Domain\Ship\ShipWeaponDamage;
use StarWars\Domain\Ship\ShipWeaponSystem;
use StarWars\Domain\ShipDamageControl\Service\ShipDamageProcessor;
use StarWars\Domain\ShipTargeting\RandomAliveShipTargetSelector;

class BattleTest extends TestCase
{
    private Fleet $fleet1;
    private Fleet $fleet2;
    private FleetCombatService $fleetCombatService;
    private Battle $battle;

    public function setUp(): void
    {
        $this->fleet1 = $this->createMock(Fleet::class);
        $this->fleet2 = $this->createMock(Fleet::class);
        $this->fleetCombatService = $this->createMock(FleetCombatService::class);

        $this->battle = new Battle(
            $this->fleet1,
            $this->fleet2,
            $this->fleetCombatService
        );
    }

    private function processBattle(): void
    {
        foreach ($this->battle->engage() as $battleTurn) {
            $this->assertTrue($battleTurn);
        }
    }

    public function testFleet1AlreadyDestroyedAtStart(): void
    {
        $this->fleet1->method('isAlive')->willReturn(false);
        $this->fleet2->method('isAlive')->willReturn(true);
        $this->fleetCombatService->expects($this->never())->method('engage');

        $this->processBattle();
    }

    public function testFleet2AlreadyDestroyedAtStart(): void
    {
        $this->fleet1->method('isAlive')->willReturn(true);
        $this->fleet2->method('isAlive')->willReturn(false);
        $this->fleetCombatService->expects($this->never())->method('engage');

        $this->processBattle();
    }

    public function testFleet1DestroyedAtFirstTurn(): void
    {
        $this->fleet1->expects($this->exactly(2))
            ->method('isAlive')
            ->willReturnOnConsecutiveCalls(true, false, false);

        $this->fleet2->method('isAlive')->willReturn(true);
        $this->fleetCombatService->expects($this->exactly(2))->method('engage')->with($this->fleet1, $this->fleet2);

        $this->processBattle();
    }

    public function testFleet2DestroyedInFirstTurn(): void
    {
        $this->fleet1->method('isAlive')->willReturn(true);

        $this->fleet2->expects($this->exactly(2))
            ->method('isAlive')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->fleetCombatService->expects($this->once())->method('engage')->with($this->fleet1, $this->fleet2);

        $this->processBattle();
    }


    /**
     * @throws Exception
     */
    public function testFleet1DestroyedAtRandomTurn(): void
    {
        $destroyTurn = random_int(1, 1000);

        $fleet1IsAliveResult = [
            ...array_fill(0, $destroyTurn - 1, true),
            false,
            false,
        ];
        $this->fleet1->expects($this->exactly($destroyTurn))
            ->method('isAlive')
            ->willReturnOnConsecutiveCalls(...$fleet1IsAliveResult);
        $this->fleet2->method('isAlive')->willReturn(true);
        $this->fleetCombatService->expects($this->exactly($destroyTurn * 2 - 2))->method('engage');

        $currentTurn = 1;
        foreach ($this->battle->engage() as $battleTurn) {
            $currentTurn++;
            $this->assertTrue($battleTurn);
        }

        $this->assertEquals($destroyTurn, $currentTurn);
    }

    public function testFleet2DestroyedAtRandomTurn(): void
    {
        $destroyTurn = random_int(1, 1000);

        $fleet2IsAliveResult = [
            ...array_fill(0, $destroyTurn * 2 - 1, true),
            false,
        ];

        $this->fleet1->method('isAlive')->willReturn(true);
        $this->fleet2->expects($this->exactly($destroyTurn * 2))
            ->method('isAlive')
            ->willReturnOnConsecutiveCalls(...$fleet2IsAliveResult);

        $currentTurn = 1;
        foreach ($this->battle->engage() as $battleTurn) {
            $currentTurn++;
            $this->assertTrue($battleTurn);
        }

        $this->assertEquals($destroyTurn, $currentTurn);
    }

    public function testShouldDestroyIn4Steps(): void
    {
        $playerShips = [
            $this->createDeathStar()
        ];
        $sithShips = [
            $this->createRebelTransport(),
            $this->createRebelTransport(),
            $this->createRebelTransport(),
            $this->createRebelTransport(),
        ];

        $battle = new Battle(
            new Fleet($playerShips),
            new Fleet($sithShips),
            new FleetCombatService(
                new RandomAliveShipTargetSelector(),
                new ShipDamageProcessor()
            )
        );

        $currentTurn = 1;
        foreach ($battle->engage() as $ignored) {
            $currentTurn++;
        }

        $this->assertEquals(4, $currentTurn);
    }

    private function createRebelTransport(): Ship
    {
        return new Ship(
            new ShipName('Rebel transport'),
            new ShipArmor(1),
            new ShipShields(0),
            new ShipWeaponSystem([]),
            new ShipCost(200000)
        );
    }

    private function createDeathStar(): Ship
    {
        return new Ship(
            new ShipName('Death Star'),
            new ShipArmor(100000000),
            new ShipShields(7000000),
            new ShipWeaponSystem(
                [
                    new ShipWeapon(
                        'heavy_turbolaser',
                        150,
                        new ShipWeaponDamage(500, 2000)
                    ),
                    new ShipWeapon(
                        'heavy_flakgun',
                        100,
                        new ShipWeaponDamage(500, 3000)
                    ),
                    new ShipWeapon(
                        'star_slayer',
                        1,
                        new ShipWeaponDamage(200000000, 200000000)
                    ),
                ]
            ),
            new ShipCost(1000000000000)
        );
    }
}
