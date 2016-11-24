<?php

namespace App\Action;

use App\Entity\User;
use App\Service\JsonResponseBuilder;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

class RegisterAction
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $body = $request->getParsedBody();

        try {
            $user = new User($body['username'], $body['email']);
            $this->em->persist($user);
            $this->em->flush();

            return (new JsonResponseBuilder($response))
                ->withStatus(201)
                ->withBody($user)
                ->build();

        } catch (UniqueConstraintViolationException $uniqueConstraintViolationException) {
            return $response->withStatus(409, 'User or email exist');

        } catch (\Exception $exception) {
            return $response->withStatus(500, 'What the hell?');
        }
    }
}