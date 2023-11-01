<?php
namespace Pyncer\Snyppet\Role\Middleware;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;
use Pyncer\App\Identifier as ID;
use Pyncer\Access\AuthenticatorInterface;
use Pyncer\Database\ConnectionInterface;
use Pyncer\Exception\UnexpectedValueException;
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
        // Database
        if (!$handler->has(ID::DATABASE)) {
            throw new UnexpectedValueException(
                'Database connection expected.'
            );
        }

        $connection = $handler->get(ID::DATABASE);
        if (!$connection instanceof ConnectionInterface) {
            throw new UnexpectedValueException('Invalid database connection.');
        }

        // Access
        if (!$handler->has(ID::ACCESS)) {
            throw new UnexpectedValueException(
                'Access authenticator expected.'
            );
        }

        $access = $handler->get(ID::ACCESS);
        if (!$access instanceof AuthenticatorInterface) {
            throw new UnexpectedValueException('Invalid access authenticator.');
        }

        if ($access->getUser() !== null) {
            $roles = new RoleManager(
                $connection,
                $access->getUser()
            );

            ID::register(ID::role());

            $handler->set(ID::role(), $roles);
        }

        return $handler->next($request, $response);
    }
}
