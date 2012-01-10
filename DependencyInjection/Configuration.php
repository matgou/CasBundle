<?php

namespace Gorg\Bundle\AuthentificatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gorg_authentificator');
	$rootNode
            ->children()
                ->scalarNode('cas_server')->end()
		->scalarNode('cas_port')->end()
		->scalarNode('cas_path')->end()
                ->scalarNode('ca_cert')->end()
            ->end();
        ;

        return $treeBuilder;
    }
}
