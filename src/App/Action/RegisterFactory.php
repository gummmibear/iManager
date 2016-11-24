<?php

namespace App\Action;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class RegisterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get(EntityManager::class);

        return new RegisterAction($em);
    }
}