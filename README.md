[![StarWars Fleet Battle Simulator](https://github.com/gnuheike/StarWarsGame-DDD-CleanArch/blob/main/cover.jpg?raw=true)](https://github.com/gnuheike/StarWarsGame-DDD-CleanArch)

# StarWars Fleet Battle Simulator

A PHP-based simulation game where two space fleets engage in battle. The project uses Domain-Driven Design and common
design patterns to separate concerns, allowing a clear separation of application logic, domain models, external
services, and presentation.

---

## Project Description

This project simulates fleet battles using space ships inspired by Star Wars. It provides mechanisms to create fleets,
process battles, and store results. The application leverages factories, adapters, and use cases to maintain a clean
codebase. Its modular design and adherence to DDD make it easily extendable and maintainable.

---

## Purpose & Unique Value

- **Purpose:**  
  Provide a framework to simulate starship battles that can be used as a basis for strategy games or testing DDD
  implementations. The project demonstrates best practices including clear domain separation and dependency injection.

- **Unique Value:**
    * Uses a combination of DDD principles and design patterns to build an extensible simulation.
    * Integrates with an external QuickMocker API to retrieve ship data.
    * Offers both console and web-based entry points (via Mezzio middleware).

---

## Modules & Components

- **Domain**  
  Contains core business logic and domain models:
    - **Battle:** Contains the battle mechanics and result computation.
    - **Fleet:** Represents a group of ships; determines fleet health.
    - **Ship:** Represents individual ships along with their characteristics (armor, shields, weapons).
    - **ShipTargeting:** Implements targeting strategies (e.g., random alive target selection).

- **Application**  
  Contains use cases, factories, and service implementations:
    - **Factories:** Create domain objects (e.g., ShipFactory, FleetFactory, ShipArmorFactory).
    - **Use Cases:** Business processes such as creating fleets (user or Sith), processing battles, and storing battle
      results.
    - **Adapters:** Bridge external APIs (e.g., QuickMockerShipProvider) to domain models.

- **Infrastructure**  
  Contains integrations:
    - **External Services:** QuickMockerClient fetches ship data via a URL.
    - **Persistence:** Provides in-memory repositories to store battle results.

- **Presentation**  
  Deals with interaction:
    - **Console Commands:** Provides a CLI command (ConsoleGameCommand) for starting the simulation.
    - **Web Routes & Middleware:** Set up using Mezzio with error handling, routing and dispatch pipelines.

- **Tests**  
  Contains PHPUnit tests that cover use cases, domain logic, and integration points.

---

## Patterns, Techniques

- **Domain-Driven Design (DDD):**  
  Separates the domain (business logic) from application and infrastructure concerns.

- **Factory Pattern:**  
  Widely used to create domain objects (e.g., ShipFactory, ShipWeaponFactory) and encapsulate construction logic.

- **Adapter Pattern:**  
  The QuickMockerShipProvider adapts external API data to the domain model.

- **Design by Contract:**  
  Enforces correct data through type hints and validation (e.g., in ShipArmor and ShipShield constructors).

- **Middleware Pipeline (Mezzio):**  
  Uses a middleware pipeline pattern for HTTP request handling. Also supports CLI commands via Symfony Console.

---

## Technologies & Libraries

- [Mezzio](https://docs.mezzio.dev/) for HTTP application development.
- [Laminas ConfigAggregator](https://docs.laminas.dev/laminas-config-aggregator/) for configuration management.
- [Symfony Console](https://symfony.com/doc/current/components/console.html) for CLI commands.
- [PHPUnit](https://phpunit.de/) for testing.
- [Arkitect](https://github.com/scheb/arkitect) for architectural rules and static analysis.
- [PHPStan](https://phpstan.org/) for static code analysis.

---

## Key Features

- **Dynamic Fleet Creation:**  
  Uses use cases and factories to generate user and enemy fleets based on available starship data.

- **Battle Simulation:**  
  Simulates battles turn–by–turn with dynamic target selection and damage calculation.

- **External Data Integration:**  
  Retrieves ship details from a QuickMocker API, mapping raw API responses to domain objects.

- **In-Memory Persistence:**  
  Temporarily store battle results to explore outcomes.

- **Console Game Command:**  
  A CLI game engine with interactive ship selection and detailed battle reporting.

---

## Interesting Code Snippets

### Factory Usage Example

The ShipFactory combines multiple factories to create a Ship with its weapon system and target selector:

```php
$ship = $this->shipFactory->createShip(
   name: $shipData['name'],
   cost: (int)$shipData['cost_in_credits'],
   armor: $shipData['body'],
   shields: $shipData['shields'],
   weapons: $weapons
);
```

### Battle Simulation Loop

The Battle domain object engages fleets until one is defeated:

```php
public function engage(): iterable
{
    while ($this->fleet1->isAlive() && $this->fleet2->isAlive()) {
        $this->engageFleets($this->fleet1, $this->fleet2);
        if (!$this->fleet2->isAlive()) {
            break;
        }
        $this->engageFleets($this->fleet2, $this->fleet1);
        yield true;
    }
}
```

### External API Adapter Example

QuickMockerShipProvider retrieves and maps external ship data:

```php
public function getShips(): array
{
    return array_map(
        $this->mapper->mapArrayToShip(...),
        $this->client->getShips()
    );
}
```

---

## External Libraries & Resources

- [Mezzio Documentation](https://docs.mezzio.dev/)
- [Laminas ConfigAggregator](https://docs.laminas.dev/laminas-config-aggregator/)
- [Symfony Console](https://symfony.com/doc/current/components/console.html)
- [PHPUnit](https://phpunit.de/)
- [PHPStan](https://phpstan.org/)
- [Arkitect](https://github.com/scheb/arkitect)

---

## Setup & Usage

1. **Install Dependencies**

   Use Composer to install dependencies:

   ```bash
   composer install
   ```

2. **Configuration Cache (Optional)**

   Clear outdated cache:

   ```bash
   php bin/clear-config-cache.php
   ```

3. **Run the Application**

    - **Via Web:** Set your web root to the `public` directory and access `index.php`.
    - **Via CLI:** Start the game using Symfony Console:

      ```bash
      php bin/console game:start
      ```

4. **Run Tests**

   Execute PHPUnit tests:

   ```bash
   ./vendor/bin/phpunit
   ```

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.