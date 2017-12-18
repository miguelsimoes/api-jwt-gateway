<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Core\Authentication\Provider;

use Application\Security\Core\Authentication\Token\Encoder\Exception\InvalidTokenException;
use Application\Security\Core\Authentication\Token\JWTToken;
use Application\Security\Core\Authentication\Token\PreAuthenticationJWTToken;
use Application\Service\JWT\ManagerInterface;
use Application\Service\JWT\Signer\Factory as SignerFactory;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Token;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * 
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class JWTAuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * @var ManagerInterface
     */
    private $manager;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var Signer
     */
    private $signer;

    /**
     * Constructor
     *
     * @param ManagerInterface $manager
     * @param string           $algorithm
     * @param string           $secret
     */
    public function __construct(ManagerInterface $manager, $algorithm, $secret)
    {
        $this->manager = $manager;
        $this->secret  = $secret;
        $this->signer  = (new SignerFactory())->create($algorithm);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(TokenInterface $token)
    {
        try {
            /* We will attempt to decode the provided token, being aware that it may be invalid */
            $data = $this->manager->decode($token);
        } catch (InvalidTokenException $ex) {
            /* We were provided with an invalid token, we will not be able to authenticate the user */
            throw new AuthenticationException($ex->getMessage(), null, $ex);
        }
        #
        # We need to ensure we received a valid token associated with the authentication request
        if ($data && $this->validateTokenData($data)) {
            /* We have been able to validate the token with success, we will now allow access */
            return new JWTToken($data, $data->getClaim('roles'));
        }
        #
        # We were not able to validate the token with success, we will not allow
        # the authentication
        throw new AuthenticationException('Unable to authenticate user with provided JWT token');
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof PreAuthenticationJWTToken;
    }

    /**
     * Validates the JWT token to ensure we will authenticate a valid user with
     * a valid token
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    private function validateTokenData(Token $token): bool
    {
        if (false === $token->verify($this->signer, $this->secret)) {
            /* We were not able to verify the token, we will not be able to use it to authenticate the request */
            throw new AuthenticationException(
                sprintf('Unable to use JWT token using algorithm "%s" when expected is "%s"', $token->getHeader('alg'), $this->signer->getAlgorithmId())
            );
        }

        return true;
    }
}
