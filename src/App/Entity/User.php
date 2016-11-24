<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    private $id;


    /**
     * @ORM\Column(name="username", type="string", length=32)
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(name="email", type="string", length=32)
     * @var string
     */
    private $email;

    public function __construct(string $username, string $email)
    {
        $this->username = $username;
        $this->email = $email;
    }

    public function getId():string
    {
        return $this->id;
    }

    public function getUsername():string
    {
        return $this->username;
    }

    /**
     */
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email
        ];
    }

}