<?php

namespace GrotonSchool\Slim\GAE;

use GrotonSchool\Slim\GAE\Actions\EmptyAction;
use Slim\App;

class RouteBuilder
{
    public static function define(App $app)
    {
        // return an empty string on GAE start/stop requests
        $app->get('/_ah/{action:.*}', EmptyAction::class);
    }
}
