<?php

namespace NVBooster\PHPCRAssetsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NVBoosterPHPCRAssetsExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');        
        
        if (key_exists('codemirror', $config)) {
            $loader->load('form.xml');
        
             
            
            if (key_exists('paths', $config['codemirror'])) {
                $container
                    ->getDefinition('nvbooster_assets.twig_extension')
                    ->addArgument($config['codemirror']['paths']);
            }
            
            $container
                ->getDefinition('nvbooster_assets.formtype.asset')
                ->addArgument(array_merge(
                    array(
                        'theme' => 'eclipse', 
                        'mode' => 'xml',
                        'lineNumbers' => true
                        
                    ), $config['codemirror']['options']
                ));
        }
        
        $bundles = $container->getParameter('kernel.bundles');
        if (isset($bundles['SonataAdminBundle'])) {
            $loader->load('admin.xml');
            
            if (key_exists('codemirror', $config)) {
                $container
                    ->getDefinition('nvbooster_assets.asset_admin')
                    ->addMethodCall('enableCodeMirror');
                $container
                    ->getDefinition('nvbooster_assets.js_asset_admin')
                    ->addMethodCall('enableCodeMirror');
                $container
                    ->getDefinition('nvbooster_assets.css_asset_admin')
                    ->addMethodCall('enableCodeMirror');
            }
        }
        
        $container
            ->getDefinition('nvbooster_assets.routing.prefix_provider')
            ->replaceArgument(0, $config['routing']['base_uri']);
        
        if ($config['phpcr']['root_path']) {
            $container->setParameter('nvbooster_assets.phpcr.root', $config['phpcr']['root_path']);
        }
        
        $root = $container->getParameter('nvbooster_assets.phpcr.root');
        
        $container
            ->getDefinition('nvbooster_assets.phpcr.initializer')
            ->addArgument(array($root));
        
        $container
            ->getDefinition('nvbooster_assets.controller')
            ->addArgument($config['filters']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = array(
            'dynamic' => array(
                'controllers_by_class' => array(
                    'NVBooster\PHPCRAssetsBundle\Asset\JsAsset' => 'nvbooster_assets.controller:serveJs',
                    'NVBooster\PHPCRAssetsBundle\Asset\CssAsset' => 'nvbooster_assets.controller:serveCss',
                    'NVBooster\PHPCRAssetsBundle\Asset\BaseAsset' => 'nvbooster_assets.controller:serveAsset'
                )
            )
        );
    
        $container->prependExtensionConfig('cmf_routing', $config);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'nvbooster_assets';
    }
}
