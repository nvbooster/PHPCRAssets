<?php
namespace NVBooster\PHPCRAssetsBundle\Admin;

use NVBooster\PHPCRAssetsBundle\Asset\CssAsset;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * CssAssetAdmin
 *
 * @author nvb <nvb@aproxima.ru>
 */
class CssAssetAdmin extends BaseAssetAdmin
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
    protected $baseRouteName = 'admin_cmf_assets_cssasset';
    
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $baseRoutePattern = '/cms/assets/cssasset';
    
    /**
     * @return array
     */
    protected function getCodeMirrorParams()
    {
        return array(
                    'lineNumbers' => true, 
                    'mode' => 'css'
                );
    }
}