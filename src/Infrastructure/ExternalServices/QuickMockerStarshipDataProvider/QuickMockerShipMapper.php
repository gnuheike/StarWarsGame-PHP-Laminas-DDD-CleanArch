<?php

declare(strict_types=1);

namespace StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider;

use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipArmor;
use StarWars\Domain\Ship\ShipCost;
use StarWars\Domain\Ship\ShipName;
use StarWars\Domain\Ship\ShipShields;
use StarWars\Domain\Ship\ShipWeapon;
use StarWars\Domain\Ship\ShipWeaponDamage;
use StarWars\Domain\Ship\ShipWeaponSystem;

class QuickMockerShipMapper
{
    public function mapArrayToShip(array $shipData): Ship
    {
        return new Ship(
            name: new ShipName($shipData['name']),
            cost: new ShipCost((int)$shipData['cost_in_credits']),
            armor: new ShipArmor($shipData['body']),
            shields: new ShipShields($shipData['shields']),
            weaponSystem: new ShipWeaponSystem(
                array_map(
                    static fn(array $weaponData) => new ShipWeapon(
                        name: $weaponData['name'],
                        amount: $weaponData['amount'],
                        damage: new ShipWeaponDamage(
                            min: $weaponData['min_damage'],
                            max: $weaponData['max_damage']
                        )
                    ),
                    $shipData['weapons']
                )
            )
        );
    }
}
