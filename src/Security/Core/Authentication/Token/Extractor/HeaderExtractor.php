<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Security\Core\Authentication\Token\Extractor;

use Application\Security\Core\Authentication\Token\Extractor\ExtractorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Attempts to retrieve JWT tokens from the HTTP headers
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class HeaderExtractor implements ExtractorInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $realm;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $realm
     */
    public function __construct($name, $realm)
    {
        $this->name  = $name;
        $this->realm = $realm;
    }

    /**
     * {@inheritdoc}
     */
    public function extract(Request $request)
    {
        if (false === $request->headers->has($this->name)) {
            /* We do not have the header to retrieve the JWT token, we will not continue */
            return;
        }
        #
        # Since we have the header we will retrieve it to attempt and get it from the configured realm
        $parts  = explode(' ', $request->headers->get($this->name));
        if (sizeof($parts) === 2 && 0 === strcasecmp($parts[0], $this->realm)) {
            /* We have been able to find the token on the request, we will return it */
            return $parts[1];
        }
    }
}
