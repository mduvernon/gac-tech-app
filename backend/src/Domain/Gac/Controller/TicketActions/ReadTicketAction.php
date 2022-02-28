<?php

namespace Domain\Gac\Controller\TicketActions;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class ReadTicketAction
 *
 * Read a single ticket action
 */
class ReadTicketAction extends AbstractTicketAction
{

    /**
     * Read Ticket default action
     *
     * @return Response
     * @throws \Exception
     */
    protected function action(): Response
    {
        // Collect input from the HTTP request
        $ticketId = (int)$this->args['id'];
        $response = $this->ticketManager->finOneById($ticketId);

        $this->logger->info("ListTicketsAction was viewed.");

        return $this->respondWithData($response);
    }
}