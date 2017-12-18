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

use Symfony\Component\HttpFoundation\Request;

/**
 * Definition of the public contract required by any implementation to retrieve
 * the JWT token from the request
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
interface ExtractorInterface
{
    /**
     * Attempts to extract the JWT token from the given request
     *
     * @param Request $request
     *
     * @return string
     */
    public function extract(Request $request);
}
