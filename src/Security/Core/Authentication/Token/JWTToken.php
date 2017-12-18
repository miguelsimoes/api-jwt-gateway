<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Core\Authentication\Token;

use Lcobucci\JWT\Token;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Implements a JWT token
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class JWTToken extends AbstractToken
{
    /**
     * @var Token
     */
    private $token;

    /**
     * Constructor
     *
     * @param Token $token
     * @param array $roles
     */
    public function __construct(Token $token, array $roles = [])
    {
        parent::__construct($roles);

        $this->token = $token;
        $this->setAuthenticated(true);
    }

    /**
     * {@inheirtdoc}
     */
    public function getCredentials()
    {
        return $this->token;
    }
}
