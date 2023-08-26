<?php

declare(strict_types=1);

namespace StarWars\Presentation\Console\Command;

use Exception;
use RuntimeException;
use StarWars\Application\UseCase\CreateSithFleet\CreateSithFleet;
use StarWars\Application\UseCase\CreateSithFleet\SithFleetGenerator;
use StarWars\Application\UseCase\CreateUserFleet\CreateUserFleet;
use StarWars\Application\UseCase\GetPlayerFleet\GetPlayerFleet;
use StarWars\Application\UseCase\GetSithFleet\GetSithFleet;
use StarWars\Application\UseCase\ProcessBattle\BattleFactory;
use StarWars\Application\UseCase\ProcessBattle\BattleFleetEnum;
use StarWars\Application\UseCase\ProcessBattle\ProcessBattle;
use StarWars\Application\UseCase\ProcessGame\ProcessGame;
use StarWars\Application\UseCase\ProcessGame\ProcessGameResponse;
use StarWars\Application\UseCase\StoreBattleResult\StoreBattleResult;
use StarWars\Domain\Fleet\ShipInterface;
use StarWars\Domain\FleetCombat\FleetCombatService;
use StarWars\Domain\Repository\ShipRepositoryInterface;
use StarWars\Domain\Repository\ShipsProviderInterface;
use StarWars\Domain\Ship\ShipDamageControl\ShipDamageControl;
use StarWars\Domain\Ship\ShipTargeting\RandomAliveShipTargetSelector;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerClient;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerShipMapper;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerShipProvider;
use StarWars\Infrastructure\Factory\FleetFactory;
use StarWars\Infrastructure\Persistence\Repository\InMemoryBattleResultRepository;
use StarWars\Infrastructure\Persistence\Repository\InMemoryShipRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsoleGameCommand extends Command
{
    protected function configure(): void
    {
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $gameProcessor = $this->createGameProcessor($input, $output);
        $response = $gameProcessor->__invoke();

        $output->writeln('');
        $output->writeln('');
        $output->writeln('<fg=blue>---------------------------------');
        $output->writeln('Game has ended');
        $output->writeln('---------------------------------</>');

        if ($response->battleResult->getWinner() === BattleFleetEnum::SITH_FLEET) {
            return $this->displaySithResults($response, $output);
        }

        return $this->processPlayerResults($response, $output);
    }

    /**
     * @throws Exception
     */
    private function createGameProcessor(InputInterface $input, OutputInterface $output): ProcessGame
    {
        $playerShipsRepository = new InMemoryShipRepository();
        $sithShipsRepository = new InMemoryShipRepository();
        $fleetFactory = new FleetFactory();

        $shipProvider = $this->createShipProvider();
        $createSithFleet = $this->createSithFleet($shipProvider, $sithShipsRepository);
        $createUserFleet = $this->createUserFleet($input, $output, $shipProvider, $playerShipsRepository);
        $getPlayerFleet = new GetPlayerFleet($playerShipsRepository, $fleetFactory);
        $getSithFleet = new GetSithFleet($sithShipsRepository, $fleetFactory);
        $battle = new ProcessBattle(
            new BattleFactory(
                new FleetCombatService(
                    new RandomAliveShipTargetSelector(),
                    new ShipDamageControl()
                )
            )
        );

        return new ProcessGame(
            $createSithFleet,
            $createUserFleet,
            $getPlayerFleet,
            $getSithFleet,
            $battle
        );
    }

    private function createShipProvider(): QuickMockerShipProvider
    {
        return new QuickMockerShipProvider(
            new QuickMockerClient('https://sdghze76cm.api.quickmocker.com/starships'),
            new QuickMockerShipMapper()
        );
    }

    /**
     * @throws Exception
     */
    private function createSithFleet(
        ShipsProviderInterface $shipProvider,
        ShipRepositoryInterface $sithShipsRepository
    ): CreateSithFleet {
        return new CreateSithFleet(
            new SithFleetGenerator($shipProvider),
            $sithShipsRepository,
            random_int(1, 10)
        );
    }

    private function createUserFleet(
        InputInterface $input,
        OutputInterface $output,
        ShipsProviderInterface $shipsProvider,
        ShipRepositoryInterface $playerShipsRepository
    ): CreateUserFleet {
        $questionHelper = $this->getHelper('question');
        if (!$questionHelper instanceof QuestionHelper) {
            throw new RuntimeException('Question helper not found');
        }

        return new CreateUserFleet(
            $shipsProvider,
            new ConsoleShipSelector($input, $output, $questionHelper),
            $playerShipsRepository
        );
    }

    private function displaySithResults(ProcessGameResponse $response, OutputInterface $output): int
    {
        $output->writeln('Sith fleet won!');
        return 0;
    }

    private function processPlayerResults(ProcessGameResponse $response, OutputInterface $output): int
    {
        $repository = new InMemoryBattleResultRepository();
        $useCase = new StoreBattleResult($repository);
        $useCase->__invoke($response->battleResult);
        $this->displayPlayerResults($response, $output);

        return 0;
    }

    private function displayPlayerResults(ProcessGameResponse $response, OutputInterface $output): void
    {
        $output->writeln('Player fleet won!');
        $output->writeln('');

        $output->writeln(
            sprintf('Player spent %s credits', $this->getShipsCost($response->battleResult->getPlayerShips()))
        );
        $output->writeln('');

        $output->writeln('Player fleet ships:');
        $this->displayShips($response->battleResult->getPlayerShips(), $output);
        $output->writeln('');


        $output->writeln('Sith fleet ships:');
        $this->displayShips($response->battleResult->getSithShips(), $output);
        $output->writeln('');

        $output->writeln(
            sprintf('Player spent %s steps', $response->battleResult->getSteps())
        );
    }

    /**
     * @param ShipInterface[] $ships
     * @return int
     */
    private function getShipsCost(array $ships): int
    {
        return array_reduce(
            $ships,
            static fn(int $carry, ShipInterface $ship) => $carry + $ship->getCost(),
            0
        );
    }

    /**
     * @param ShipInterface[] $ships
     * @param OutputInterface $output
     * @return void
     */
    private function displayShips(array $ships, OutputInterface $output): void
    {
        $count = count($ships);
        $namesList = implode(
            ', ',
            array_map(static fn($ship) => $ship->getName(), $ships)
        );

        $output->writeln(
            sprintf(
                'Fleet has %d ships: %s',
                $count,
                $namesList
            )
        );
    }
}
