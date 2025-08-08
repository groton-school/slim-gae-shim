<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE\Actions;

use GrotonSchool\Slim\Norms\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\ServerRequest;
use Slim\Http\Response;

class EmptyAction extends AbstractAction
{
    protected function invokeHook(
        ServerRequest $request,
        Response $response,
        array $args = []
    ): ResponseInterface {
        return $response;
    }
}
