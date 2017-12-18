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

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * 
 */
class PreAuthenticationJWTToken extends AbstractToken
{
    /**
     * @var string
     */
    private $credentials;

    /**
     * Constructor
     *
     * @param string $credentials
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;

        parent::__construct([]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthenticated($authenticated)
    {
        throw new \LogicException('A PreAuthenticationToken may *never* be setted as authenticated');
    }
}
