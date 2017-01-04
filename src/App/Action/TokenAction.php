<?php

namespace App\Action;

use App\Service\JsonResponseBuilder;
use Doctrine\ORM\EntityRepository;
use Firebase\JWT\JWT;
use Psr\Http\Message\{
    ServerRequestInterface,
    ResponseInterface
};
use App\Service\JwtPayload;
use App\Entity\User;

class TokenAction
{
    /** @var  EntityRepository */
    private $userRepository;

    public function __construct(EntityRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $token = ['jwt' => ''];
        $username = $request->getParsedBody()['username'];

        /** @var User $user */
        $user = $this->userRepository->findOneBy(['username'=>$username]);

        if ($user) {
            $payload = (new JwtPayload())
                ->getPayload($user);

            $token = [
                'jwt' => JWT::encode($payload, 'secret', 'HS256')
            ];
        }

        return (new JsonResponseBuilder($response))
            ->withBody($token)
            ->build();
    }
}