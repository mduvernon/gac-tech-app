<?php

namespace Domain\Gac\Controller\TicketActions;

use Psr\Http\Message\ResponseInterface as Response;
use Domain\Gac\Exception\TicketNotFoundException;

/**
 * Class DeleteTicketAction
 */
class DeleteTicketAction extends AbstractTicketAction
{

    /**
     * Delete Ticket default action
     *
     * @return Response
     * @throws \Exception
     */
    protected function action(): Response
    {
        // Collect input from the HTTP request
        $ticketId = (int)$this->args['id'];

        $ticket = $this->ticketManager->finOneById($ticketId);
        if (!$ticket) throw new TicketNotFoundException();

        $response = ['success' => FALSE]; // Unsuccessful action by default
        if ($this->ticketManager->delete($ticket)) {
            $response = ['success' => TRUE];
        }

        $this->logger->info("DeleteTicketAction was viewed.");

        return $this->respondWithData($response);
    }
}