<?php

namespace App\Action;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Interop\Container\ContainerInterface;

class UserListFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        /** @var EntityRepository $userRepository */
        $userRepository = $em->getRepository(User::class);

        return new UserListAction($userRepository);
    }
}