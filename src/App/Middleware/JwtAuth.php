<?php
namespace App\Middleware;

use Doctrine\ORM\EntityRepository;

use Firebase\JWT\{
    ExpiredException,
    JWT
};
use Psr\Http\Message\{
    ServerRequestInterface,
    ResponseInterface
};

use Zend\Stratigility\MiddlewareInterface;

class JwtAuth implements MiddlewareInterface
{
    private $userRepository;

    public function __construct(EntityRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if (!$request->hasHeader('Authorization')) {
            return $response->withStatus(401, 'Not authorized');
        }

        $authHeader = $request->getHeader('Authorization')[0];
        list($jwt) = sscanf( $authHeader, 'Bearer %s');

        try {
            $token = JWT::decode($jwt, 'secret', ['HS256']);
        } catch (ExpiredException $exception) {
            return $response->withStatus(401, 'Token expired');
        }

        $new = $request->withAttribute('token', $token )
            ->withAttribute('user', $this->userRepository->find($token->data->userId));

        return $next($new, $response);
    }
}