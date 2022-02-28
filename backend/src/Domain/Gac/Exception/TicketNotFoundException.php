<?php
declare(strict_types=1);

namespace Domain\Gac\Exception;

use App\Exception\DomainRecordNotFoundException;

/**
 * Class TicketNotFoundException
 *
 * @package App\Exception
 */
class TicketNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The ticket you requested does not exist.';
}
