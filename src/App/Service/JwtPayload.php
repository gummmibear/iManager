<?php

namespace App\Service;

use App\Entity\User;

class JwtPayload
{
    const SERVER_NAME = 'iManager.dev';

    public function getPayload(User $user) : array
    {
        $tokenId    = base64_encode(mcrypt_create_iv(32));
        $issuedAt   = time();
        $notBefore  = $issuedAt;
        $expire     = $notBefore + 60*10;
        $serverName = self::SERVER_NAME;

        return [
            'iat'  => $issuedAt,
            'jti'  => $tokenId,
            'iss'  => $serverName,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => [
                'userId'   => $user->getId(),
                'userName' => $user->getUsername(),
            ]
        ];
    }
}