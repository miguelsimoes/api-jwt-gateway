<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers the token extractors with the token extractor chain service
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class TokenExtractorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->has('security.authentication.listener.jwt')) {
            /* We do not have an extractor chain configured, we will not be able to register them */
            return;
        }
        #
        # We will retrieve the chain definition from the container so we can register
        # the concrete implementation of the extractor
        $definition = $container->findDefinition('security.authentication.listener.jwt');

        foreach ($container->findTaggedServiceIds('token.extractor') as $service => $tags) {
            /* Cycle all the services tagged with the corresponding tag and add them to the chain */
            $definition->addMethodCall('addExtractor', [ new Reference($service) ]);
        }
    }
}
