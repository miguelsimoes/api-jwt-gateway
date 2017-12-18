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

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

/**
 * Definition of the contract required by a user instance that will be generated
 * by JWT tokens
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
interface UserInterface extends BaseUserInterface
{
}
