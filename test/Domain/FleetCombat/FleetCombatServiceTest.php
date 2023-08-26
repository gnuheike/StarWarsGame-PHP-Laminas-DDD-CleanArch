<?php

namespace Test\Domain\FleetCombat;

use PHPUnit\Framework\TestCase;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\FleetCombat\FleetCombatService;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\ShipDamageControl\Service\ShipDamageProcessor;
use StarWars\Domain\ShipTargeting\RandomAliveShipTargetSelector;

class FleetCombatServiceTest extends TestCase
{
    private FleetCombatService $fleetCombatService;
    private RandomAliveShipTargetSelector $shipTargetSelector;
    private ShipDamageProcessor $shipDamageProcessorService;

    public function testEngage(): void
    {
        $shipMock = $this->createMock(Ship::class);

        $attackingFleetMock = $this->createMock(Fleet::class);
        $attackingFleetMock->method('getShips')
            ->willReturn([$shipMock]);

        $defendingFleetMock = $this->createMock(Fleet::class);
        $defendingFleetMock->method('getShips')
            ->willReturn([$shipMock]);
        $defendingFleetMock->expects($this->once())
            ->method('isAlive')
            ->willReturn(true);

        $this->shipTargetSelector->expects($this->once())
            ->method('getShipFromArray')
            ->with([$shipMock])
            ->willReturn($shipMock);

        $this->shipDamageProcessorService->expects($this->once())
            ->method('processShipDamageToShip')
            ->with($this->equalTo($shipMock), $this->equalTo($shipMock));

        $this->fleetCombatService->engage($attackingFleetMock, $defendingFleetMock);
    }

    protected function setUp(): void
    {
        $this->shipTargetSelector = $this->createMock(RandomAliveShipTargetSelector::class);
        $this->shipDamageProcessorService = $this->createMock(ShipDamageProcessor::class);

        $this->fleetCombatService = new FleetCombatService(
            $this->shipTargetSelector,
            $this->shipDamageProcessorService
        );
    }
}
