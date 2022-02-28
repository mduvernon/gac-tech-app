<?php
declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;


return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepositoryInterface interface to its in memory implementation
    $containerBuilder->addDefinitions([
        // DI of TicketManager
        \Domain\Gac\Manager\TicketManagerInterface::class => function (ContainerInterface $c) {
            $em = $c->get(EntityManagerInterface::class);
            $slugger = $c->get(\Easybook\SluggerInterface::class);
            return new \Domain\Gac\Manager\TicketManager(
                $em,
                $slugger,
                \Domain\Gac\Entity\Ticket::class
            );
        },

        \Domain\Gac\Helper\TicketArchiveHelperInterface::class => function (ContainerInterface $c) {
            return new \Domain\Gac\Helper\TicketArchiveHelper;
        }
    ]);
};
