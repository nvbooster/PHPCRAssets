<?php

namespace NVBooster\PHPCRAssetsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Exception\LogicException;

/**
 * @author nvb
 *
 */
class TwigFormThemePass implements CompilerPassInterface
{
    /**
     * @{inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('nvbooster_assets.formtype.asset')) {           
            $twigFormThemes = $container->getParameter('twig.form.resources');
            $twigFormThemes[] = 'NVBoosterPHPCRAssetsBundle:Form:textasset_widget.html.twig';
            
            $container->setParameter('twig.form.resources', $twigFormThemes);
        }
    }
}