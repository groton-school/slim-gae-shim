<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE;

use DI\ContainerBuilder;
use Google\Cloud\Logging\LoggingClient;
use GrotonSchool\Slim\Norms\DependenciesInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class Dependencies implements DependenciesInterface
{
    public function inject(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            // log to Google Cloud Logger
            LoggerInterface::class => function (ContainerInterface $c) {
                /** @var SettingsInterface $settings */
                $settings = $c->get(SettingsInterface::class);
                $client = new LoggingClient([
                    'projectId' => $settings->getProjectId()
                ]);
                $logger = $client->psrBatchLogger($settings->getLoggerName());
                return $logger;
            }

        ]);
    }
}
