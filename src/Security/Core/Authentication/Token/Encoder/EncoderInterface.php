<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Core\Authentication\Token\Encoder;

use Application\Security\Core\Authentication\Token\Encoder\Exception\InvalidTokenException;

/**
 * Definition of the public contract required to any encoder and/or decoder to
 * handle the conversion between a JWT token and the data associated
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
interface EncoderInterface
{
    /**
     * Transforms the JWT token data into a readable list of attributes
     *
     * @param  string $token
     * 
     * @return array
     *
     * @throws InvalidTokenException
     */
    public function decode($token);
}
