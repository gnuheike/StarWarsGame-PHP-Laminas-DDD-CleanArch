# PHP Project

This is a PHP project that is containerized using Docker and Docker Compose. It utilizes PHP 8.2, includes Xdebug and Composer. This README provides guidelines on how to build and run the Docker container for this project.

## Prerequisites

Ensure you have Docker and Docker Compose installed on your machine. If not, you can download and install Docker from the [official Docker website](https://www.docker.com/get-started) and Docker Compose from the [official Docker Compose website](https://docs.docker.com/compose/install/). Verify the successful installation of Docker and Docker Compose by running the commands:

```bash
docker --version
docker-compose --version
```

These commands should display the installed Docker and Docker Compose versions.

## Running the Application
To execute the application, use the `run.sh` script. This script starts the Docker container running the application. Execute the script with:
```bash
./run.sh
```
This command will start the Docker container in the foreground. The application within the container runs on PHP's built-in server on port 80, which is mapped to port 8000 on your host machine. You can access the application at `http://localhost:8000` in your web browser.


## Running Tests
Execute tests for the project using the `test.sh` script. This script executes multiple commands within the Docker container to run unit tests, fix code standard issues, and analyze the code using PHPStan. Run this script using:

```bash
./test.sh
```