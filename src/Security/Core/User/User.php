<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Core\User;

use Application\Security\Core\User\UserInterface;

/**
 * Implementation of a user representation created with JWT tokens
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class User implements UserInterface
{
    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     */
    private $username;

    /**
     * Constructor
     *
     * @param string $username
     * @param array  $roles
     */
    public function __construct($username, array $roles = [])
    {
        $this->username = $username;
        $this->roles    = $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }
}
