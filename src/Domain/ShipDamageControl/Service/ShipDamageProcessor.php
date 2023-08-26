<?php

declare(strict_types=1);

namespace StarWars\Domain\ShipDamageControl\Service;

use InvalidArgumentException;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipWeapon;

class ShipDamageProcessor
{
    public function processShipDamageToShip(Ship $damageEmitter, Ship $damageReceiver): void
    {
        if ($damageReceiver->isDestroyed()) {
            throw new InvalidArgumentException('Cannot damage a destroyed ship');
        }

        foreach ($damageEmitter->getWeaponSystem()->getAllWeapons() as $weapon) {
            if ($damageReceiver->isDestroyed()) {
                break;
            }
            $this->processWeaponDamageToShip($damageReceiver, $weapon);
        }
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
}
