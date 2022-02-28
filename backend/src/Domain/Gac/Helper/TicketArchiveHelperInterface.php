<?php

namespace Domain\Gac\Helper;

interface TicketArchiveHelperInterface
{

    /**
     * Do read the archive file
     *
     * @return array
     */
    public function readArchive(): array;
}