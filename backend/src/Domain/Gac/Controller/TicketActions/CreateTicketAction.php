<?php

namespace Domain\Gac\Controller\TicketActions;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class CreateTicketAction
 *
 * This controller perform the ticket creation
 */
class CreateTicketAction extends AbstractTicketAction
{

    /**
     * Create Ticket default action
     *
     * @return Response
     * @throws \Exception
     */
    protected function action(): Response
    {
        // Collect input from the HTTP request
        $data = (array)$this->request->getParsedBody();

        // check the given data
        $this->checkData($data);

        $response = ['success' => FALSE]; // Unsuccessful action by default
        if ($this->ticketManager->create($data)) {
            $response = ['success' => TRUE];
        }

        $this->logger->info("CreateTicketActions was viewed.");

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