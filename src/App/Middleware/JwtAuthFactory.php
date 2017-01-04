<?php
namespace App\Middleware;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class JwtAuthFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        /** @var EntityRepository $userRepository */
        $userRepository = $em->getRepository(User::class);

        return new JwtAuth($userRepository);
    }
}