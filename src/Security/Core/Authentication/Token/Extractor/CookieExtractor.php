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
 * Attempts to retrieve the JWT tokens from the HTTP headers
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class CookieExtractor implements ExtractorInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function extract(Request $request)
    {
        return $request->cookies->get($this->name);
    }
}
