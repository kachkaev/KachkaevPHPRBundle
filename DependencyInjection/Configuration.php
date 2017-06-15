<?php

namespace Kachkaev\PHPRBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('kachkaev_phpr');

        $rootNode
            ->children()
                ->enumNode('default_engine')
                    ->values(array('command_line'))
                    ->defaultValue('command_line')
                    ->info('default R engine (command_line is the only one currently implemented)')
                    ->end()
                ->arrayNode('engines')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('path_to_r')
                            ->defaultValue('/usr/bin/R')
                            ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
