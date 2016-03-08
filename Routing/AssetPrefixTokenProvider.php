<?php
namespace NVBooster\PHPCRAssetsBundle\Routing;

use Symfony\Cmf\Component\RoutingAuto\TokenProviderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Cmf\Component\RoutingAuto\UriContext;

/**
 * @author nvb
 *
 */
class AssetPrefixTokenProvider implements TokenProviderInterface
{
    private $prefix;
    
    /**
     * @param string $prefix
     */
    public function __construct($prefix = '')
    {
        $this->prefix = preg_replace('@^\/|\/$@', '', $prefix);    
    }
    
    /**
     * {@inheritDoc}
     */
    public function provideValue(UriContext $uriContext, $options)
    {
        return $this->prefix;
    }
    
    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolverInterface $optionsResolver)
    {
    }
}