<?php
/**
 * Created by PhpStorm.
 * User: gbear
 * Date: 22.11.16
 * Time: 21:48
 */

namespace App\Service;


use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;

class JsonResponseBuilder
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function withBody($body) : self
    {
        $this->response->getBody()->write(json_encode($body));

        return $this;
    }

    public function withStatus(int $status, $message = null) :self
    {
        $this->response->withStatus($status, $message);

        return $this;
    }

    public function build() : MessageInterface
    {
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}