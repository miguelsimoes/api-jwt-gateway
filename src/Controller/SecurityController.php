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

/**
 * Controller responsible for handling all the required features associated with
 * the application security
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login/check", name="security_check")
     * @Method({"GET"})
     *
     * Action responsible for making available the authentication validation path
     * to the application security listener
     *
     * @throws \LogicException
     */
    public function loginAction()
    {
        die('got to the controller');
    }
}
