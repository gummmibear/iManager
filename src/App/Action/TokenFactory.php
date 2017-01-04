<?php

namespace App\Action;

use Doctrine\ORM\{
    EntityManager,
    EntityRepository
};
use Interop\Container\ContainerInterface;
use App\Entity\User;

class TokenFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        /** @var EntityRepository $userRepository */
        $userRepository = $em->getRepository(User::class);

        return new TokenAction($userRepository);
    }
}