<?php

namespace Domain\Gac\Controller\TicketActions;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class ListTicketsAction
 */
class ListTicketsArchivesAction extends AbstractTicketAction
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

        $response = $this->ticketArchiveHelper->readArchive($filter);
        $this->logger->info("ListTicketsArchivesAction was viewed.");

        return $this->respondWithData(json_encode($response));
    }

}