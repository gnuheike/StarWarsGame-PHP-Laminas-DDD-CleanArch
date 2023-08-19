<?php

namespace Test\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider;

use JsonException;
use PHPUnit\Framework\TestCase;
use StarWars\Domain\Ship\Ship;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerClient;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerShipMapper;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerShipProvider;

class QuickMockerShipProviderTest extends TestCase
{
    private array $sampleData;
    private QuickMockerClient $client;
    private QuickMockerShipMapper $mapper;

    /**
     * @throws JsonException
     */
    public function setUp(): void
    {
        $this->sampleData = json_decode(
            file_get_contents(__DIR__ . '/sample_data.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $this->client = $this->createMock(QuickMockerClient::class);
        $this->client->method('getShips')->willReturn($this->sampleData);

        $this->mapper = $this->createMock(QuickMockerShipMapper::class);
    }

    public function testValidData(): void
    {
        $this->assertIsArray($this->sampleData);
        $this->assertNotEmpty($this->sampleData);
    }

    public function testReturnResultOnValidData(): void
    {
        $repository = new QuickMockerShipProvider(
            $this->client,
            $this->mapper
        );

        $this->mapper->expects($this->exactly(count($this->sampleData)))
            ->method('mapArrayToShip')
            ->willReturn($this->createMock(Ship::class));

        $ships = $repository->getShips();

        $this->assertIsArray($ships);
        $this->assertNotEmpty($ships);
        $this->assertCount(count($this->sampleData), $ships);
    }
}
