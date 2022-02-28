<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/tickets', function (Group $group) {
        $group->get('', \Domain\Gac\Controller\TicketActions\ListTicketsAction::class);
        $group->get('/archives', \Domain\Gac\Controller\TicketActions\ListTicketsArchivesAction::class);
        $group->get('/{id}', \Domain\Gac\Controller\TicketActions\ReadTicketAction::class);
        $group->post('', \Domain\Gac\Controller\TicketActions\CreateTicketAction::class);
        $group->put('/{id}', \Domain\Gac\Controller\TicketActions\UpdateTicketAction::class);
        $group->delete('/{id}', \Domain\Gac\Controller\TicketActions\DeleteTicketAction::class);
    });
};
