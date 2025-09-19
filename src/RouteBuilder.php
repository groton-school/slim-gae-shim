<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE;

use GrotonSchool\Slim\GAE\Actions\EmptyAction;
use GrotonSchool\Slim\Norms\RouteBuilderInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Interfaces\RouteGroupInterface;

class RouteBuilder implements RouteBuilderInterface
{
    public function define(App $app, ?MiddlewareInterface ...$innerMiddleware): RouteGroupInterface
    {
        // return an empty string on GAE start/stop requests
        $group = $app->group('/_ah', function (RouteCollectorProxyInterface $ah) {
            $ah->get('/{action:.*}', EmptyAction::class);
        });

        foreach ($innerMiddleware as $middleware) {
            $group = $group->add($middleware);
        }
        return $group;
    }
}
