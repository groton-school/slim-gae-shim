<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE;

use GrotonSchool\Slim\GAE\Actions\EmptyAction;
use Slim\App;

class Routes
{
    public static function register(App $app)
    {
        $app->get('/_ah/{action:.*}', EmptyAction::class);
    }
};
