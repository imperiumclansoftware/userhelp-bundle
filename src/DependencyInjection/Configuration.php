<?php

namespace ICS\UserhelpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {

        $treeBuilder = new TreeBuilder('userhelp');
        $treeBuilder->getRootNode()->children()
            ->scalarNode('helpButtonIdentifier')->defaultValue('helpButton')->end()
            ->scalarNode('introButtonIdentifier')->defaultValue('introButton')->end()
            ->enumNode('helpColor')
            ->values(['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'dark'])
            ->defaultValue('primary')
            ->end()
            ->enumNode('introTheme')
            ->values(['dark', 'flattener', 'modern', 'nassim', 'nazanin', 'royal'])
            ->defaultValue('modern')
            ->end()
            ->arrayNode('helps')
            ->arrayPrototype()
            ->children()
            ->arrayNode('elements')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->enumNode('position')->values(['left', 'top', 'right', 'bottom'])->defaultValue('left')->end()
            ->scalarNode('description')->defaultValue('')->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('intros')
            ->arrayPrototype()
            ->children()
            ->arrayNode('elements')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->scalarNode('identifier')->defaultValue('')->end()
            ->scalarNode('title')->defaultValue('')->end()
            ->scalarNode('description')->defaultValue('')->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
