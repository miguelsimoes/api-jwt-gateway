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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * The application configuration extension
 *
 * @author Miguel Simões <msimoes@gmail.com>
 */
class ApplicationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        #
        # We need to set the required parameters to the services that are required
        $this->loadTokenExtractorConfiguration($config['token_extractors'], $container);
    }

    /**
     * Loads the configuration for the required token extractors
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadTokenExtractorConfiguration(array $config, ContainerBuilder $container)
    {
        if (array_key_exists('header', $config) && $config['header']['enabled']) {
            /* We have the header extractor enabled, we will need to configure it */
            $container
                ->getDefinition('security.token.extractor.header')
                ->replaceArgument(0, $config['header']['name'])
                ->replaceArgument(1, $config['header']['realm'])
            ;
        }

        if (array_key_exists('cookie', $config) && $config['cookie']['enabled']) {
            /* We have the cookie extractor enabled, we will need to configure it */
            $container
                ->getDefinition('security.token.extractor.cookie')
                ->replaceArgument(0, $config['cookie']['name'])
            ;
        }
    }
}
