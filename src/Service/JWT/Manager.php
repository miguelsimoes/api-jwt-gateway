<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Service\JWT;

use Application\Security\Core\User\UserInterface;
use Application\Security\Core\Authentication\Token\Encoder\EncoderInterface;
use Application\Security\Core\Authentication\Token\JWTToken;
use Application\Security\Core\Authentication\Token\PreAuthenticationJWTToken;
use Application\Service\JWT\ManagerInterface;

/**
 * Default implementation of the manager to handle JWT tokens
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class Manager implements ManagerInterface
{
    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * Constructor
     *
     * @param EncoderInterface $encoder
     */
    public function __construct(EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user)
    {
        die('Creating the JWT token');
    }

    /**
     * {@inheritdoc}
     */
    public function decode(PreAuthenticationJWTToken $token)
    {
        return $this->encoder->decode($token->getCredentials());
    }
}
