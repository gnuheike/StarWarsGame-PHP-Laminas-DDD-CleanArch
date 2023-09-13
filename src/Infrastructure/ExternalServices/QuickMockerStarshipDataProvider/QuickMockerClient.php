<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */
declare(strict_types=1);

namespace StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider;

use JsonException;
use RuntimeException;

class QuickMockerClient
{
    public function __construct(private readonly string $url)
    {
    }

    public function getShips(): array
    {
        try {
            return json_decode(
                file_get_contents($this->url),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new RuntimeException('Error while parsing JSON data from QuickMocker API: ' . $e->getMessage());
        }
    }
}
