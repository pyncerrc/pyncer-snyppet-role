<?php
namespace Pyncer\Snyppet\Role\Middleware;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;
use Pyncer\App\Identifier as ID;
use Pyncer\Http\Server\MiddlewareInterface;
use Pyncer\Http\Server\RequestHandlerInterface;
use Pyncer\Snyppet\Role\RoleManager;

class RoleMiddleware implements MiddlewareInterface
{
    public function __invoke(
        PsrServerRequestInterface $request,
        PsrResponseInterface $response,
        RequestHandlerInterface $handler
    ): PsrResponseInterface
    {
        $connection = $handler->get(ID::DATABASE);

        $roles = new RoleManager($connection);

        ID::register('roles');

        $handler->set(ID::roles(), $roles);

        return $handler->next($request, $response);
    }
}
