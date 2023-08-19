<?php

declare(strict_types=1);

namespace StarWars\Presentation\Console;

use StarWars\Presentation\Console\Command\ConsoleGameCommand;

final class ConsoleGameProvider
{
    public function __invoke(): array
    {
        return [
            'laminas-cli' => $this->getCliConfig(),
        ];
    }

    public function getCliConfig(): array
    {
        return [
            'commands' => [
                'game:start' => ConsoleGameCommand::class,
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [
                ConsoleGameCommand::class => ConsoleGameCommand::class,
            ],
        ];
    }
}
