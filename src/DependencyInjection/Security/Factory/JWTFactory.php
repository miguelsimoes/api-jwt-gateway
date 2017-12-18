<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Implementation of the security listener required for the application
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class JWTFactory implements SecurityFactoryInterface
{
   
    protected $options = [
        'check_path' => '/login',
        'login_path' => '/login'
    ];

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('check_path')
                    ->cannotBeEmpty()->defaultValue('security_check')
                ->end()
                ->scalarNode('login_path')
                    ->cannotBeEmpty()->isRequired()
                ->end()
                ->scalarNode('algorithm')
                    ->cannotBeEmpty()->defaultValue('HS256')
                ->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $authProviderId = $this->createAuthProviderId($container, $id, $config, $userProvider);
        $listenerId     = $this->createListener($container, $id, $config, $userProvider);
        $entryPointId   = $this->createEntryPoint($container, $id, $config, $userProvider);

        return [ $authProviderId, $listenerId, $entryPointId ];
    }

    /**
     * Generates the authentication provider service to be used with the authentication
     * listener
     *
     * @param ContainerBuilder $container
     * @param string           $id
     * @param array            $config
     * @param string           $userProviderId
     *
     * @return string
     */
    protected function createAuthProviderId(ContainerBuilder $container, $id, array $config, $userProviderId)
    {
        $provider = 'security.authentication.provider.jwt.'.$id;
        $container
            ->setDefinition($provider, new ChildDefinition('security.authentication.provider.jwt'))
            ->replaceArgument(1, $config['algorithm'])
        ;

        return $provider;
    }

    /**
     * Generates the authentication entry point to be used with the authenticator
     *
     * @param ContainerBuilder $container
     * @param string           $id
     * @param array            $config
     * @param string           $userProviderId
     *
     * @return string
     */
    protected function createEntryPoint(ContainerBuilder $container, $id, array $config, $userProviderId)
    {
        $entryPoint = 'security.authentication.entry_point.jwt.'. $id;

        $container
            ->setDefinition($entryPoint, new ChildDefinition('security.authentication.entry_point.jwt'))
            ->addArgument($config['login_path'])
        ;

        return $entryPoint;
    }

    /**
     * Generates the authentication listener to be used with the authenticator
     *
     * @param ContainerBuilder $container
     * @param string           $id
     * @param array            $config
     * @param string           $userProviderId
     *
     * @return string
     */
    protected function createListener(ContainerBuilder $container, $id, array $config, $userProviderId)
    {
        $listener = 'security.authentication.listener.jwt.'. $id;

        $container
            ->setDefinition($listener, new ChildDefinition('security.authentication.listener.jwt'))
            ->replaceArgument(3, array_intersect_key($config, $this->options))
        ;

        return $listener;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'jwt';
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return 'pre_auth';
    }
}
