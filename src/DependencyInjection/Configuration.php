<?php

/*
 * This file is part of Miguel Simões API Gateway package.
 *
 * (c) Miguel Simões <msimoes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * The application configuration definition
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('application', 'array');
        #
        # Generate the required sections to be available as a configuration
        $this->addTokenExtractorSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds the token extractor configuration parameters to the definition
     *
     * @param ArrayNodeDefinition $node
     */
    private function addTokenExtractorSection(ArrayNodeDefinition $node)
    {
        $node
            ->fixXmlConfig('token_extractor')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('token_extractors')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('header')
                            ->addDefaultsIfNotSet()
                            ->canBeDisabled()
                            ->children()
                                ->scalarNode('name')->cannotBeEmpty()->defaultValue('Authorization')->end()
                                ->scalarNode('realm')->cannotBeEmpty()->defaultValue('Bearer')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cookie')
                            ->addDefaultsIfNotSet()
                            ->canBeDisabled()
                            ->children()
                                ->scalarNode('name')->cannotBeEmpty()->defaultValue('Bearer')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
