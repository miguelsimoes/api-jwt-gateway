<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Http\EntryPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\HttpUtils;

/**
 * @author Miguel Simões <msimoes@gmail.com>
 */
class JWTAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var string
     */
    private $destination;

    /**
     * @var HttpKernelInterface
     */
    private $httpKernel;

    /**
     * @var HttpUtils
     */
    private $httpUtils;

    /**
     * Constructor
     *
     * @param HttpKernelInterface $httpKernel
     * @param HttpUtils           $httpUtils
     * @param string              $destination
     */
    public function __construct(HttpKernelInterface $httpKernel, HttpUtils $httpUtils, $destination)
    {
        $this->httpKernel  = $httpKernel;
        $this->httpUtils   = $httpUtils;
        $this->destination = $destination;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $response = $this->httpKernel->handle($this->httpUtils->createRequest($request, $this->destination), HttpKernelInterface::SUB_REQUEST);
        if (Response::HTTP_OK === $response->getStatusCode()) {
            /* We received a not expected status code, we will need to update it */
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }
}
