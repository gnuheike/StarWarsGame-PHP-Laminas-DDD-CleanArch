<?php

declare(strict_types=1);

namespace StarWars\Infrastructure\Persistence\Repository;

use RuntimeException;
use StarWars\Domain\Fleet\ShipInterface;
use StarWars\Domain\Repository\ShipRepositoryInterface;

final class InMemoryShipRepository implements ShipRepositoryInterface
{
    /**
     * @var ShipInterface[]
     */
    private array $ships;

    public function getAllShips(): array
    {
        if (!isset($this->ships)) {
            throw new RuntimeException('No ships added to the repository');
        }

        return $this->ships;
    }

    public function addShip(ShipInterface $ship): void
    {
        $this->ships[] = $ship;
    }
}
