<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE\Actions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EmptyAction
{
    public function __invoke(RequestInterface $_, ResponseInterface $response)
    {
        return $response;
    }
}
