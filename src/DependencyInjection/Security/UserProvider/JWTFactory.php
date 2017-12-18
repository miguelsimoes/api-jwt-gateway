<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\DependencyInjection\Security\UserProvider;

use Application\Security\Core\User\User;
use Application\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\UserProvider\UserProviderFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Implements the services required to use the JWT provider
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class JWTFactory implements UserProviderFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('class')
                    ->defaultValue(User::class)
                    ->cannotBeEmpty()
                    ->validate()
                        ->ifTrue(function ($class) {
                            return false === (new \ReflectionClass($class))->implementsInterface(UserInterface::class);
                        })
                        ->thenInvalid('The user class "%s" does not implement the required '. UserInterface::class .' interface')
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, $config)
    {
        $container
            ->setDefinition($id, new ChildDefinition('security.user.provider.jwt'))
            ->replaceArgument(0, $config['class'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'jwt';
    }
}
