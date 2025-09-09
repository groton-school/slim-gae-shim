<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE;

use GrotonSchool\Slim\GAE\Actions\EmptyAction;
use GrotonSchool\Slim\Norms\RouteBuilderInterface;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Interfaces\RouteGroupInterface;

class RouteBuilder implements RouteBuilderInterface
{
    public function define(App $app): RouteGroupInterface
    {
        // return an empty string on GAE start/stop requests
        return $app->group('/_ah', function (RouteCollectorProxyInterface $ah) {
            $ah->get('/{action:.*}', EmptyAction::class);
        });
    }
}
