<?php

namespace StarWars\Domain\Fleet;

use StarWars\Domain\Ship\ShipWeaponSystem;

interface ShipInterface
{
    public function getWeaponSystem(): ShipWeaponSystem;

    public function isDestroyed(): bool;

    public function isShieldsDepleted(): bool;

    public function receiveShieldsDamage(int $damage): int;

    public function receiveArmorDamage(int $damage): int;

    public function getCost(): int;

    public function getName(): string;
}
