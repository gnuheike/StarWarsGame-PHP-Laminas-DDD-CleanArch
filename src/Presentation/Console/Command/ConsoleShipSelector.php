<?php

declare(strict_types=1);

namespace StarWars\Presentation\Console\Command;

use StarWars\Application\UseCase\CreateUserFleet\ShipSelectorInterface;
use StarWars\Domain\Fleet\ShipInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

final class ConsoleShipSelector implements ShipSelectorInterface
{
    private const STOP = 'Stop';

    public function __construct(
        private readonly InputInterface  $input,
        private readonly OutputInterface $output,
        private readonly QuestionHelper  $question
    ) {
    }

    /**
     * @param ShipInterface[] $ships
     * @return ?ShipInterface
     */
    public function selectShip(array $ships): ?ShipInterface
    {
        $shipByNames = [];
        foreach ($ships as $ship) {
            $shipDisplayTitle = sprintf(
                '%s [%s%s%s]',
                $ship->getName(),
                "<fg=red>",
                $this->humanReadableValue($ship->getCost()),
                "</>"
            );
            $shipByNames[$shipDisplayTitle] = $ship;
        }

        $shipsChoice = new ChoiceQuestion(
            'Please select your ship',
            [self::STOP] + array_keys($shipByNames)
        );
        $shipsChoice->setErrorMessage('Ship %s is invalid.');
        $ship = $this->question->ask($this->input, $this->output, $shipsChoice);
        if ($ship === self::STOP) {
            $this->output->writeln('You have decided to stop.');
            return null;
        }

        $this->output->writeln(sprintf('You have selected %s', $ship));
        $this->output->writeln('');
        return $shipByNames[$ship];
    }

    private function humanReadableValue(int $value): string
    {
        return number_format($value, 0, '.', ' ');
    }
}
