<?php

namespace Domain\Gac\Controller\TicketActions;

use Psr\Http\Message\ResponseInterface as Response;
use Domain\Gac\Exception\TicketNotFoundException;

/**
 * Class UpdateTicketAction
 */
class UpdateTicketAction extends AbstractTicketAction
{

    /**
     * Update Ticket default action
     *
     * @return Response
     * @throws \Exception
     */
    protected function action(): Response
    {
        // Collect input from the HTTP request
        $ticketId = (int)$this->args['id'];
        $data = (array)$this->request->getParsedBody();

        $this->checkData($data);

        $ticket = $this->ticketManager->finOneById($ticketId);
        if (!$ticket) throw new TicketNotFoundException();

        $response = ['success' => FALSE]; // Unsuccessful action by default
        if ($this->ticketManager->update($ticket, $data)) {
            $response = ['success' => TRUE];
        }

        $this->logger->info("UpdateTicketAction was viewed.");

        return $this->respondWithData($response);
    }

    /**
     * Check the ticket formatted data
     *
     * @param array $data
     * @throws \Exception
     */
    private function checkData(array $data)
    {
        if (
            !array_key_exists('name', $data) ||
            !array_key_exists('description', $data)
        ) {
            throw new \InvalidArgumentException('Invalid data given');
        }
    }
}