<?php

declare(strict_types=1);

namespace StarWars\Application\Factory;

use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipTargeting\RandomAliveShipTargetSelector;

class ShipFactory
{
    public function __construct(
        private readonly ShipWeaponSystemFactory $weaponsFactory,
        private readonly ShipArmorFactory $armorFactory,
        private readonly ShipShieldsFactory $shieldsFactory,
        private readonly ShipCostFactory $costFactory,
        private readonly ShipNameFactory $nameFactory,
        private readonly RandomAliveShipTargetSelector $targetSelector,
    ) {
    }

    public function createShip(
        string $name,
        int $cost,
        int $armor,
        int $shields,
        array $weapons,
    ): Ship {
        return new Ship(
            name: $this->nameFactory->createShipName($name),
            cost: $this->costFactory->createShipCost($cost),
            armor: $this->armorFactory->createShipArmor($armor),
            shields: $this->shieldsFactory->createShipShields($shields),
            weaponSystem: $this->weaponsFactory->createShipWeaponSystem($weapons),
            targetSelector: $this->targetSelector
        );
    }
}
