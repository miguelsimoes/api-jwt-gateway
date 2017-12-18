<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Service\JWT\Signer\Exception;

/**
 * Base exception thrown when there is an error during the generation of the Signer
 * instance
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class SignerException extends \LogicException
{
}
