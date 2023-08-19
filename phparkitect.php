<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\RuleBuilders\Architecture\Architecture;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $files = ClassSet::fromDir(__DIR__ . '/src');
    $config->add(
        $files,
        ...dddComponentRules(),
        ...namingRules(),
    );
};

function dddComponentRules(): iterable
{
    return Architecture::withComponents()
        ->component('Domain')->definedBy('Domain\*')
        ->component('Infrastructure')->definedBy('Infrastructure\*')
        ->component('Application')->definedBy('Application\*')
        ->component('Presentation')->definedBy('Presentation\*')
        ->where('Domain')->shouldOnlyDependOnComponents()
        ->where('Application')->shouldOnlyDependOnComponents('Domain')
        ->where('Infrastructure')->mayDependOnComponents('Domain', 'Application')
        ->where('Presentation')->mayDependOnComponents('Domain', 'Application', 'Infrastructure')
        ->rules();
}

function namingRules(): iterable
{
    yield Rule::allClasses()
        ->that(new HaveNameMatching('*DataProvider'))
        ->should(new ResideInOneOfTheseNamespaces('*\Infrastructure\ExternalServices\\'))
        ->because('Data providers should reside in the proper namespace.');
}