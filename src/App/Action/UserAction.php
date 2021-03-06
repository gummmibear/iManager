<?php
namespace App\Action;

use App\Service\JsonResponseBuilder;
use Psr\Http\Message\{
    ServerRequestInterface,
    ResponseInterface
};

class UserAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $user = $request->getAttribute('user');

        return (new JsonResponseBuilder($response))
            ->withBody($user)
            ->build();
    }
}