<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\Ship;

class QuickMockerShipFactory
{
    public function __construct(
        private readonly ShipFactory $shipFactory,
    ) {
    }

    public function mapArrayToShip(array $shipData): Ship
    {
        $weapons = array_map(
            static fn(array $weaponData) => [
                'name' => $weaponData['name'],
                'amount' => (int)$weaponData['amount'],
                'minDamage' => $weaponData['min_damage'],
                'maxDamage' => $weaponData['max_damage']
            ],
            $shipData['weapons']
        );

        return $this->shipFactory->createShip(
            name: $shipData['name'],
            cost: (int)$shipData['cost_in_credits'],
            armor: $shipData['body'],
            shields: $shipData['shields'],
            weapons: $weapons
        );
    }
}
