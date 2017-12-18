<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Service\JWT\Signer;

use Application\Service\JWT\Signer\Exception\UnknownSignerAlgorithmException;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Ecdsa\Sha256 as EcdsaSha256;
use Lcobucci\JWT\Signer\Ecdsa\Sha384 as EcdsaSha384;
use Lcobucci\JWT\Signer\Ecdsa\Sha512 as EcdsaSha512;
use Lcobucci\JWT\Signer\Hmac\Sha256  as HmacSha256;
use Lcobucci\JWT\Signer\Hmac\Sha384  as HmacSha384;
use Lcobucci\JWT\Signer\Hmac\Sha512  as HmacSha512;
use Lcobucci\JWT\Signer\Rsa\Sha256   as RsaSha256;
use Lcobucci\JWT\Signer\Rsa\Sha384   as RsaSha384;
use Lcobucci\JWT\Signer\Rsa\Sha512   as RsaSha512;

/**
 * Factory to retrieve the correct signer class based on the provided algorithm
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class Factory
{
    /**
     * @var array
     */
    private $callbacks;

    /**
     * Constructor
     *
     * @param array $callbacks
     */
    public function __construct(array $callbacks = [])
    {
        $this->callbacks = array_merge(
            [
                'HS256' => [$this, 'createHmacSha256'],
                'HS384' => [$this, 'createHmacSha384'],
                'HS512' => [$this, 'createHmacSha512'],
                'ES256' => [$this, 'createEcdsaSha256'],
                'ES384' => [$this, 'createEcdsaSha384'],
                'ES512' => [$this, 'createEcdsaSha512'],
                'RS256' => [$this, 'createRsaSha256'],
                'RS384' => [$this, 'createRsaSha384'],
                'RS512' => [$this, 'createRsaSha512']
            ],
            $callbacks
        );
    }

    /**
     * Gets the signer instance associated with the provided algorithm
     *
     * @param string $algorithm
     *
     * @return Signer
     *
     * @throws UnknownSignerAlgorithmException
     */
    public function create($algorithm)
    {
        if (false === isset($this->callbacks[$algorithm])) {
            /* We have been provided with an algorithm that is not defined, we will not be able to generate the signer */
            throw new UnknownSignerAlgorithmException(
                sprintf('Unable to retrieve a valid Signer instance for algorithm "%s"', $algorithm)
            );
        }
        #
        # We have been able to find the provided algorithm to have a Signer instance, we will return it
        return call_user_func($this->callbacks[$algorithm]);
    }

    /**
     * @return HmacSha256
     */
    private function createHmacSha256()
    {
        return new HmacSha256();
    }

    /**
     * @return HmacSha384
     */
    private function createHmacSha384()
    {
        return new HmacSha384();
    }

    /**
     * @return HmacSha512
     */
    private function createHmacSha512()
    {
        return new HmacSha512();
    }

    /**
     * @return RsaSha256
     */
    private function createRsaSha256()
    {
        return new RsaSha256();
    }

    /**
     * @return RsaSha384
     */
    private function createRsaSha384()
    {
        return new RsaSha384();
    }

    /**
     * @return RsaSha512
     */
    private function createRsaSha512()
    {
        return new RsaSha512();
    }

    /**
     * @return EcdsaSha256
     */
    private function createEcdsaSha256()
    {
        return new EcdsaSha256();
    }

    /**
     * @return EcdsaSha384
     */
    private function createEcdsaSha384()
    {
        return new EcdsaSha384();
    }

    /**
     * @return EcdsaSha512
     */
    private function createEcdsaSha512()
    {
        return new EcdsaSha512();
    }
}
