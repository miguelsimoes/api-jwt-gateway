<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Http\Firewall;

use Application\Security\Core\Authentication\Token\Extractor\ExtractorInterface;
use Application\Security\Core\Authentication\Token\PreAuthenticationJWTToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * @author Miguel Simões <msimoes@gmail.com>
 */
class JWTListener implements ListenerInterface
{
    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    /**
     * @var ExtractorInterface
     */
    private $extractors;

    /**
     * @var HttpUtils
     */
    private $httpUtils;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @param HttpUtils                      $httpUtils
     * @param AuthenticationManagerInterface $authenticationManager
     * @param array                          $extractors
     * @param array                          $options
     */
    public function __construct(HttpUtils $httpUtils, AuthenticationManagerInterface $authenticationManager, array $extractors = [], array $options = [])
    {
        $this->authenticationManager = $authenticationManager;
        $this->httpUtils             = $httpUtils;
        $this->extractors            = $extractors;
        $this->options               = array_merge($this->getDefaultOptions(), $options);
    }

    /**
     * Adds a new token extractor to be used with the listener so we are able
     * to attempt to retrieve the token from the request
     *
     * @param ExtractorInterface $extractor
     */
    public function addExtractor(ExtractorInterface $extractor)
    {
        $this->extractors[] = $extractor;
    }

    /**
     * Gets the default options to be used with the authentication listener
     *
     * @return array
     */
    private function getDefaultOptions(): array
    {
        return [
            'check_path' => 'login_service',
            'login_path' => 'login_service'
        ];
    }

    /**
     * Retrieves the authentication token from the request
     *
     * @param  Request $request
     *
     * @return string
     */
    private function getToken(Request $request)
    {
        #
        # No token has been retrieved, we will attempt to retrieve it
        foreach ($this->extractors as $extractor) {
            /* Cycle all the extractors and verify whether we have been able to extract it */
            $token = $extractor->extract($request);

            if ($token) {
                /* We have been able to retrieve the token from the request, we will return it */
                return $token;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handle(GetResponseEvent $event)
    {
        $credentials = $this->getToken($event->getRequest());
        if (null === $credentials) {
            /* The current request does not require authentication, we will allow the request to continue */
            return;
        }
        #
        # The current action will require authentication, so we will need to handle it
        $token = $this->authenticationManager->authenticate(new PreAuthenticationJWTToken($credentials));
    }
}
