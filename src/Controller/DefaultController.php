<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The default controller for the application
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     * @Method({"GET"})
     *
     * The default action for the controller
     *
     * @param Request $request
     *
     * @return Response
     */
    public function defaultAction(Request $request): Response
    {
    }
    /**
     * @Route("/teste", name="test")
     * @Method({"GET"})
     *
     * The default action for the controller
     *
     * @param Request $request
     *
     * @return Response
     */
    public function testAction(Request $request): Response
    {
    }
}
