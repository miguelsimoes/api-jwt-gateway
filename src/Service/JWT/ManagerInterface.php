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
use Application\Security\Core\Authentication\Token\PreAuthenticationJWTToken;

/**
 * Definition of the contract required for a token manager which will make
 * convenient method available
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
interface ManagerInterface
{
    /**
     * Creates a JWT token from an authenticated UserInstance
     *
     * @param UserInterface $user
     */
    public function create(UserInterface $user);

    /**
     * @param PreAuthenticationJWTToken $token
     */
    public function decode(PreAuthenticationJWTToken $token);
}
