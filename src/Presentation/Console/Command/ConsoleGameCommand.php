<?php

declare(strict_types=1);

namespace StarWars\Presentation\Console\Command;

use Exception;
use RuntimeException;
use StarWars\Application\Adapter\QuickMockerShipProvider;
use StarWars\Application\Factory\FleetFactory;
use StarWars\Application\Factory\QuickMockerShipFactory;
use StarWars\Application\Factory\ShipArmorFactory;
use StarWars\Application\Factory\ShipCostFactory;
use StarWars\Application\Factory\ShipFactory;
use StarWars\Application\Factory\ShipNameFactory;
use StarWars\Application\Factory\ShipShieldsFactory;
use StarWars\Application\Factory\ShipWeaponDamageFactory;
use StarWars\Application\Factory\ShipWeaponFactory;
use StarWars\Application\Factory\ShipWeaponSystemFactory;
use StarWars\Application\UseCase\CreateSithFleet\CreateSithFleet;
use StarWars\Application\UseCase\CreateSithFleet\SithFleetGenerator;
use StarWars\Application\UseCase\CreateUserFleet\CreateUserFleet;
use StarWars\Application\UseCase\ProcessBattle\BattleFactory;
use StarWars\Application\UseCase\ProcessBattle\BattleFleetEnum;
use StarWars\Application\UseCase\ProcessBattle\BattleResult;
use StarWars\Application\UseCase\ProcessBattle\ProcessBattle;
use StarWars\Application\UseCase\StoreBattleResult\StoreBattleResult;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipProviderInterface;
use StarWars\Domain\Ship\ShipTargeting\RandomAliveShipTargetSelector;
use StarWars\Infrastructure\ExternalServices\QuickMockerStarshipDataProvider\QuickMockerClient;
use StarWars\Infrastructure\Persistence\Repository\InMemoryBattleResultRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsoleGameCommand extends Command
{
    private FleetFactory $fleetFactory;
    private ShipProviderInterface $shipProvider;

    protected function configure(): void
    {
        $this->fleetFactory = new FleetFactory();

        $shipFactory = new ShipFactory(
            weaponsFactory: new ShipWeaponSystemFactory(
                new ShipWeaponFactory(
                    new ShipWeaponDamageFactory()
                )
            ),
            armorFactory: new ShipArmorFactory(),
            shieldsFactory: new ShipShieldsFactory(),
            costFactory: new ShipCostFactory(),
            nameFactory: new ShipNameFactory(),
            targetSelector: new RandomAliveShipTargetSelector()
        );

        $this->shipProvider = new QuickMockerShipProvider(
            new QuickMockerClient('https://sdghze76cm.api.quickmocker.com/starships'),
            new QuickMockerShipFactory($shipFactory)
        );
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $battleResult = $this->runGame($input, $output);

        $output->writeln('');
        $output->writeln('');
        $output->writeln('<fg=blue>---------------------------------');
        $output->writeln('Game has ended');
        $output->writeln('---------------------------------</>');

        if ($battleResult->getWinner() === BattleFleetEnum::SITH_FLEET) {
            $output->writeln('Sith fleet won!');
            return 0;
        }

        return $this->processPlayerResults($battleResult, $output);
    }

    /**
     * @throws Exception
     */
    private function runGame(InputInterface $input, OutputInterface $output): BattleResult
    {
        $sithFleet = $this->createSithFleet();
        $userFleet = $this->createUserFleet($input, $output);

        return (new ProcessBattle(new BattleFactory()))->__invoke($userFleet, $sithFleet);
    }

    /**
     * @throws Exception
     */
    private function createSithFleet(): Fleet
    {
        $useCase = new CreateSithFleet(
            new SithFleetGenerator($this->shipProvider),
            $this->fleetFactory,
            random_int(1, 10)
        );

        return $useCase->__invoke();
    }

    private function createUserFleet(
        InputInterface $input,
        OutputInterface $output
    ): Fleet {
        $questionHelper = $this->getHelper('question');
        if (!$questionHelper instanceof QuestionHelper) {
            throw new RuntimeException('Question helper not found');
        }

        $useCase = new CreateUserFleet(
            $this->shipProvider,
            new ConsoleShipSelector($input, $output, $questionHelper),
            $this->fleetFactory
        );

        return $useCase->__invoke();
    }

    private function processPlayerResults(BattleResult $battleResult, OutputInterface $output): int
    {
        $repository = new InMemoryBattleResultRepository();
        $useCase = new StoreBattleResult($repository);
        $useCase->__invoke($battleResult);

        $this->displayPlayerResults($battleResult, $output);

        return 0;
    }

    private function displayPlayerResults(BattleResult $battleResult, OutputInterface $output): void
    {
        $output->writeln('Player fleet won!');
        $output->writeln('');

        $output->writeln(
            sprintf('Player spent %s credits', $this->getShipsCost($battleResult->getPlayerShips()))
        );
        $output->writeln('');

        $output->writeln('Player fleet ships:');
        $this->displayShips($battleResult->getPlayerShips(), $output);
        $output->writeln('');


        $output->writeln('Sith fleet ships:');
        $this->displayShips($battleResult->getSithShips(), $output);
        $output->writeln('');

        $output->writeln(
            sprintf('Player spent %s steps', $battleResult->getSteps())
        );
    }

    /**
     * @param Ship[] $ships
     * @return int
     */
    private function getShipsCost(array $ships): int
    {
        return array_reduce(
            $ships,
            static fn (int $carry, Ship $ship) => $carry + $ship->cost->getValue(),
            0
        );
    }

    /**
     * @param Ship[] $ships
     * @param OutputInterface $output
     * @return void
     */
    private function displayShips(array $ships, OutputInterface $output): void
    {
        $count = count($ships);
        $namesList = implode(
            ', ',
            array_map(static fn ($ship) => $ship->name->getValue(), $ships)
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
