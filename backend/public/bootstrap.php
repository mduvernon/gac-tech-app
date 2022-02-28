<?php

declare(strict_types=1);

use DI\ContainerBuilder;

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up services
$services = require __DIR__ . '/../app/services.php';
$services($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

return $container;