<?php

namespace NVBooster\PHPCRAssetsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use NVBooster\PHPCRAssetsBundle\DependencyInjection\NVBoosterPHPCRAssetsExtension;
use NVBooster\PHPCRAssetsBundle\DependencyInjection\Compiler\TwigFormThemePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass;

/**
 * @author nvb
 *
 */
class NVBoosterPHPCRAssetsBundle extends Bundle
{
    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\HttpKernel\Bundle\Bundle::getContainerExtension()
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new NVBoosterPHPCRAssetsExtension();
        }
    
        return $this->extension;
    }
    
    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\HttpKernel\Bundle\Bundle::build()
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    
        if (class_exists('Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass')) {
            $container->addCompilerPass(
                DoctrinePhpcrMappingsPass::createXmlMappingDriver(
                    array(
                        realpath(__DIR__ . '/Resources/config/doctrine-phpcr') => 'NVBooster\PHPCRAssetsBundle\Asset',
                    ),
                    array('cmf_core.persistence.phpcr.manager_name'),
                    false,
                    array('NVBoosterPHPCRAssetsBundle' => 'NVBooster\PHPCRAssetsBundle\Asset')
                )
            );
            
            $container->addCompilerPass(new TwigFormThemePass());
        }
    }
}
