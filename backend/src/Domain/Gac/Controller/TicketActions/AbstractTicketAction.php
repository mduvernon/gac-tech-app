<?php

namespace Domain\Gac\Controller\TicketActions;

use App\Core\Actions\Action;
use Domain\Gac\Helper\TicketArchiveHelperInterface;
use Domain\Gac\Manager\TicketManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractTicketAction
 */
abstract class AbstractTicketAction extends Action
{

    /**
     * @var TicketManagerInterface
     */
    protected TicketManagerInterface $ticketManager;

    /**
     * @var TicketArchiveHelperInterface
     */
    protected TicketArchiveHelperInterface $ticketArchiveHelper;

    /**
     * @param LoggerInterface $logger
     * @param TicketManagerInterface $ticketManager
     * @param TicketArchiveHelperInterface $ticketArchiveHelper
     */
    public function __construct(
        LoggerInterface              $logger,
        TicketManagerInterface       $ticketManager,
        TicketArchiveHelperInterface $ticketArchiveHelper
    )
    {
        parent::__construct($logger);
        $this->ticketManager = $ticketManager;
        $this->ticketArchiveHelper = $ticketArchiveHelper;
    }

}