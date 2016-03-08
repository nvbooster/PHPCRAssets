<?php
namespace NVBooster\PHPCRAssetsBundle\Admin;

use NVBooster\PHPCRAssetsBundle\Asset\JsAsset;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * JsAssetAdmin
 *
 * @author nvb <nvb@aproxima.ru>
 */
class JsAssetAdmin extends BaseAssetAdmin
{
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $translationDomain = 'NvboosterPHPCRAssets';
    
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $baseRouteName = 'admin_cmf_assets_jsasset';
    
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $baseRoutePattern = '/cms/assets/jsasset';
    
    /**
     * @return array
     */
    protected function getCodeMirrorParams()
    {
        return array(
                    'lineNumbers' => true, 
                    'mode' => 'javascript'
                );
    }
}