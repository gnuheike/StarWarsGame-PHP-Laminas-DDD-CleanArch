<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use InvalidArgumentException;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Fleet\ShipInterface;
use StarWars\Domain\Ship\ShipTargeting\RandomAliveShipTargetSelector;

class Ship implements ShipInterface
{
    public function __construct(
        private readonly ShipName $name,
        private readonly ShipArmor $armor,
        private readonly ShipShields $shields,
        private readonly ShipWeaponSystem $weaponSystem,
        private readonly ShipCost $cost,
        private readonly RandomAliveShipTargetSelector $targetSelector
    ) {
    }

    public function getName(): string
    {
        return $this->name->getValue();
    }

    public function getCost(): int
    {
        return $this->cost->getValue();
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

        foreach ($this->getWeaponSystem()->getAllWeapons() as $weapon) {
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

    public function getWeaponSystem(): ShipWeaponSystem
    {
        return $this->weaponSystem;
    }

    private function processWeaponDamageToShip(Ship $damageReceiver, ShipWeapon $weapon): void
    {
        $damageValue = $weapon->getWeaponDamage()->getDamageValue() * $weapon->getAmount();

        if (!$damageReceiver->isShieldsDepleted()) {
            $exceedDamage = $damageReceiver->receiveShieldsDamage($damageValue);
            $damageValue = $exceedDamage;
        }

        if ($damageValue > 0) {
            $damageReceiver->receiveArmorDamage($damageValue);
        }
    }

    public function isShieldsDepleted(): bool
    {
        return $this->shields->isDepleted();
    }

    public function receiveShieldsDamage(int $damage): int
    {
        return $this->shields->receiveDamage($damage);
    }

    public function receiveArmorDamage(int $damage): int
    {
        return $this->armor->receiveDamage($damage);
    }
}
