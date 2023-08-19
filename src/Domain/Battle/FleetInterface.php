<?php

namespace StarWars\Domain\Battle;

interface FleetInterface
{
    public function getShips(): array;

    public function isAlive(): bool;
}
