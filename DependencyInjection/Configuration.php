<?php

namespace NVBooster\PHPCRAssetsBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nvbooster_assets');
        $rootNode            
            ->children()            
                ->arrayNode('phpcr')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('root_path')
                            ->info('Defines path in PHPCR tree for assets to store in')
                            ->defaultValue('')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('filters')
                    ->addDefaultsIfNotSet()
                    ->info('Defines default filters for asset types')
                    ->fixXmlConfig('filter', 'css')
                    ->fixXmlConfig('filter', 'js')
                    ->children()
                        ->arrayNode('css')
                            ->addDefaultsIfNotSet()
                        ->end()
                        ->arrayNode('js')
                            ->addDefaultsIfNotSet()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('routing')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('base_uri')
                            ->info('Defines base uri for routes generated')
                            ->defaultValue('assets')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('codemirror')
                    ->info('Configuring codemirror js library (external)')
                    ->children()
                        ->arrayNode('paths')
                            ->children()
                                ->scalarNode('js')->end()
                                ->scalarNode('css')->end()
                                ->scalarNode('modes_dir')->end()
                                ->scalarNode('themes_dir')->end()
                            ->end()
                        ->end()
                        ->arrayNode('options')                            
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
            
        return $treeBuilder;
    }
}
