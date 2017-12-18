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

use Application\Service\JWT\Signer\Exception\SignerException;

/**
 * Exception thrown when requested with an unknown algorithm to generate the Signer
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class UnknownSignerAlgorithmException extends SignerException
{
}
