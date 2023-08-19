#!/bin/bash

echo "\e[31m--- PHPUNIT ---\e[0m"
docker-compose run --rm app vendor/bin/phpunit

echo "\e[31m--- PHP-CS-FIXER ---\e[0m"
docker-compose run --rm app vendor/bin/php-cs-fixer fix src

echo "\e[31m--- PHPSTAN ---\e[0m"
docker-compose run --rm app vendor/bin/phpstan analyse src

echo "\e[31m--- PHPARKITECT ---\e[0m"
docker-compose run --rm app vendor/bin/phparkitect check --config=phparkitect.php
