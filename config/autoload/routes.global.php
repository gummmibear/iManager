<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
            App\Action\UserAction::class => App\Action\UserAction::class
        ],
        'factories' => [
            App\Action\UserListAction::class => App\Action\UserListFactory::class,
            App\Action\TokenAction::class => App\Action\TokenFactory::class,
            App\Action\RegisterAction::class => App\Action\RegisterFactory::class,
            App\Middleware\JwtAuth::class => App\Middleware\JwtAuthFactory::class
        ],
    ],

    'routes' => [
        [
            'name' => 'token',
            'path' => '/token',
            'middleware' => App\Action\TokenAction::class,
            'allowed_methods' => ['POST'],
        ],
        [
            'name' => 'register',
            'path' => '/register',
            'middleware' => App\Action\RegisterAction::class,
            'allowed_methods' => ['POST']
        ],
        [
            'name' => 'userlist',
            'path' => '/userlist',
            'middleware' =>
                [
                    App\Middleware\JwtAuth::class,
                    App\Action\UserListAction::class,
                ],
            'allowed_methods' => ['GET']
        ],
        [
            'name' => 'me',
            'path' => '/me',
            'middleware' =>
                [
                    App\Middleware\JwtAuth::class,
                    App\Action\UserAction::class
                ],
            'allowed_methods' => ['GET']
        ]
    ],
];
