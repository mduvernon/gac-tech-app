<?php
declare(strict_types=1);

namespace App\Exception;

/**
 * Class TicketNotFoundException
 *
 * @package App\Exception
 */
class TicketNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The ticket you requested does not exist.';
}
