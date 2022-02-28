<?php

namespace Domain\Gac\Manager;

use App\Exception\TicketNotFoundException;
use Domain\Gac\Entity\Ticket;

/**
 * Interface TicketManagerInterface
 */
interface TicketManagerInterface
{

    const PAGINATE_MAX = 25;

    /**
     * Create Ticket with the given data
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Find all tickets and paginate by the given criteria
     *
     * @param int $start
     * @param int $end
     * @param array $criteria
     * @return array
     * @throws \Exception
     */
    public function findAllPaginate(int $start = 0, $end = self::PAGINATE_MAX, array $criteria = []): array;


    /**
     * Find One ticket by the given id
     *
     * @param int $id
     * @return Ticket
     * @throws TicketNotFoundException
     */
    public function finOneById(int $id): Ticket;

    /**
     * Update one Ticket with the given criteria
     *
     * @param Ticket $ticket
     * @param array $data
     * @return mixed
     */
    public function update(Ticket $ticket, array $data);

    /**
     * Delete one Ticket by the given criteria
     *
     * @param Ticket $ticket
     * @return mixed
     */
    public function delete(Ticket $ticket);
}