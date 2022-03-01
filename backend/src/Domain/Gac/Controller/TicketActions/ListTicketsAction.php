<?php

namespace Domain\Gac\Controller\TicketActions;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class ListTicketsAction
 */
class ListTicketsAction extends AbstractTicketAction
{

    /**
     * List Tickets default action
     *
     * @return Response
     * @throws \Exception
     */
    protected function action(): Response
    {
        $query = $this->request->getQueryParams();

        $filter = [];
        if (isset($query['filter'])) {
            $filter = json_decode($query['filter'], true);
            if (!is_array($filter)) $filter = [];
        }

        if (isset($filter['totalCall'])) {
            $response = $this->ticketManager->findTotalCall();
        } elseif (isset($filter['topTen'])) {
            $response = $this->ticketManager->findTopTen();
        } elseif (isset($filter['totalSMS'])) {
            $response = $this->ticketManager->findTotalSMS();
        } else {
            throw new \InvalidArgumentException('Unexpected filter given!');
        }

        $this->logger->info("ListTicketsAction was viewed.");

        return $this->respondWithData($response);
    }

}