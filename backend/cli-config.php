<?php

declare(strict_types=1);

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$cnt = require_once __DIR__ . '/public/bootstrap.php';

return ConsoleRunner::createHelperSet($cnt->get(\Doctrine\ORM\EntityManagerInterface::class));
