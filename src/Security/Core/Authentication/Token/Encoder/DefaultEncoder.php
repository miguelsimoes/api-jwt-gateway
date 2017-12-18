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

use Application\Security\Core\Authentication\Token\Encoder\EncoderInterface;
use Application\Security\Core\Authentication\Token\Encoder\Exception\InvalidTokenException;
use Lcobucci\JWT\Parser;

/**
 * Default implementation of a JWT token encoder using the lcobucci/jwt library
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class DefaultEncoder implements EncoderInterface
{
    /**
     * {@inheritdoc}
     */
    public function decode($token)
    {
        try {
            /* Attempt to parse the provided token into an array of data associated with the token */
            $data = (new Parser())->parse($token);
        } catch (\InvalidArgumentException $ex) {
            /* We were not able to retrieve data from the provided token due to being invalid */
            throw new InvalidTokenException($ex->getMessage(), null, $ex);
        }
        #
        # We have been able to retrieve the data from the payload, we will return it
        return $data;
    }
}
