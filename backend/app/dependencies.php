<?php
declare(strict_types=1);

use App\Core\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Define dependencies
 */
return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);// get settings from the container

            $loggerSettings = $settings->get('logger'); // get the logger setting from the global settings
            $logger = new Logger($loggerSettings['name']); // init the monolog logger

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        \Easybook\SluggerInterface::class => function (ContainerInterface $c) {
            return new \Easybook\Slugger();
        },
        EntityManagerInterface::class => static function (ContainerInterface $c): EntityManagerInterface {
            /** @var SettingsInterface $settings */
            $settings = $c->get(SettingsInterface::class);// get settings from the container

            $doctrineSettings = $settings->get('doctrine'); // get the logger setting from the global settings

            $reader = new AnnotationReader();
            $driver = new AnnotationDriver($reader, $doctrineSettings['metadata_dirs']);

            $ormConfiguration = Setup::createAnnotationMetadataConfiguration(
                $doctrineSettings['metadata_dirs'],
                $doctrineSettings['dev_mode'],
                null,
                $doctrineSettings['dev_mode'] ? null : new FilesystemCache($doctrineSettings['cache_dir'])
            );
            $ormConfiguration->setMetadataDriverImpl($driver);

            return EntityManager::create(
                $doctrineSettings['connection'],
                $ormConfiguration
            );
        }
    ]);
};
