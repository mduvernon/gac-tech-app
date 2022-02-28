<?php
declare(strict_types=1);

use App\Core\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    $app->add(SessionMiddleware::class);
};
