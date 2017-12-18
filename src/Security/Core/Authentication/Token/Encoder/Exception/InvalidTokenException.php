<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Core\Authentication\Token\Encoder\Exception;

/**
 * Exception thrown when the JWT token being handled is considered invalid
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class InvalidTokenException extends EncoderException
{
}
