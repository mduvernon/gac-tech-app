<?php
declare(strict_types=1);

namespace App\Exception;

/**
 * Class UserNotFoundException
 *
 * @package App\Exception
 */
class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
