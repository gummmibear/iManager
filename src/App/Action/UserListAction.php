<?php

namespace App\Action;

use App\Service\JsonResponseBuilder;
use Doctrine\ORM\EntityRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class UserListAction
{
    /** @var  EntityRepository */
    private $userRepository;

    public function __construct(EntityRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return (new JsonResponseBuilder($response))
            ->withBody($this->userRepository->findAll())
            ->build();
    }
}