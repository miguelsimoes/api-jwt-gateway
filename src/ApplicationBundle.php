<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application;

use Application\DependencyInjection\Compiler\TokenExtractorPass;
use Application\DependencyInjection\Security\Factory\JWTFactory      as JWTListenerFactory;
use Application\DependencyInjection\Security\UserProvider\JWTFactory as JWTUserProviderFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * The base bundle for the application
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class ApplicationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        #
        # Retrieve the security extension so we can add the custom factories
        $extension = $container->getExtension('security');

        $extension->addSecurityListenerFactory(new JWTListenerFactory());
        $extension->addUserProviderFactory(new JWTUserProviderFactory());
        #
        # Add the compilers required by the application allow a more fluent development
        $container->addCompilerPass(new TokenExtractorPass());
    }
}
