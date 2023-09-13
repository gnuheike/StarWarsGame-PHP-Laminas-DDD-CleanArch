<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use InvalidArgumentException;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Ship\ShipTargeting\RandomAliveShipTargetSelector;

class Ship
{
    public function __construct(
        public readonly ShipName $name,
        public readonly ShipCost $cost,
        public readonly ShipArmor $armor,
        public readonly ShipShields $shields,
        public readonly ShipWeaponSystem $weaponSystem,
        private readonly RandomAliveShipTargetSelector $targetSelector
    ) {
    }

    public function fireToFleet(Fleet $defendingFleet): void
    {
        $targetShip = $this->targetSelector->getShipFromArray($defendingFleet->getShips());
        $this->fireToShip($targetShip);
    }

    private function fireToShip(Ship $damageReceiver): void
    {
        if ($damageReceiver->isDestroyed()) {
            throw new InvalidArgumentException('Cannot damage a destroyed ship');
        }

        foreach ($this->weaponSystem->getAllWeapons() as $weapon) {
            if ($damageReceiver->isDestroyed()) {
                break;
            }
            $this->processWeaponDamageToShip($damageReceiver, $weapon);
        }
    }

    public function isDestroyed(): bool
    {
        return $this->armor->isDepleted();
    }

    private function processWeaponDamageToShip(Ship $damageReceiver, ShipWeapon $weapon): void
    {
        $damageValue = $weapon->getWeaponDamage()->getDamageValue() * $weapon->getAmount();

        if (!$damageReceiver->shields->isDepleted()) {
            $exceedDamage = $damageReceiver->shields->receiveDamage($damageValue);
            $damageValue = $exceedDamage;
        }

        if ($damageValue > 0) {
            $damageReceiver->armor->receiveDamage($damageValue);
        }
    }
}
