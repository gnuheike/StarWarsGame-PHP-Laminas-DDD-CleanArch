<?php

declare(strict_types=1);

namespace StarWars\Domain\Ship;

class ShipWeapon
{
    public function __construct(
        private readonly string           $name,
        private readonly int              $amount,
        private readonly ShipWeaponDamage $damage,
    ) {
    }

    public function getWeaponDamage(): ShipWeaponDamage
    {
        return $this->damage;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
