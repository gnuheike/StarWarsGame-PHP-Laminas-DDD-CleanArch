<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

use StarWars\Domain\Fleet\ShipInterface;

class Ship implements ShipInterface
{
    public function __construct(
        private readonly ShipName         $name,
        private readonly ShipArmor        $armor,
        private readonly ShipShields      $shields,
        private readonly ShipWeaponSystem $weaponSystem,
        private readonly ShipCost         $cost
    ) {
    }

    public function getWeaponSystem(): ShipWeaponSystem
    {
        return $this->weaponSystem;
    }

    public function isDestroyed(): bool
    {
        return $this->armor->isDepleted();
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

    public function getName(): string
    {
        return $this->name->getValue();
    }

    public function getCost(): int
    {
        return $this->cost->getValue();
    }
}
