<?php
namespace NVBooster\PHPCRAssetsBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use NVBooster\PHPCRAssetsBundle\Asset\BaseAsset;

/**
 * AssetAdmin
 *
 * @author nvb <nvb@aproxima.ru>
 */
class BaseAssetAdmin extends Admin
{   
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $baseRouteName = 'admin_cmf_assets_baseasset';
    
    /**
     * {@inheritDoc}
     *
     * @var string
     */
    protected $baseRoutePattern = '/cms/assets/baseasset';

    /**
     * @var boolean
     */
    protected $codeMirrorEnabled = false;
    
    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->addIdentifier('name', 'text');
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureFormFields()
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $group = $formMapper
            ->with('General')
                ->add('name', 'text');
                
        if ($this->codeMirrorEnabled) {
            $group->add('content', 'textasset', array(
                'required' => false,
                'codemirror' => $this->getCodeMirrorParams()
            ));
        } else {
            $group->add('content', 'textarea');
        }
        $group->end();
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureDatagridFilters()
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name', 'doctrine_phpcr_string');
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::getExportFormats()
     */
    public function getExportFormats()
    {
        return array();
    }

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\DoctrinePHPCRAdminBundle\Admin\Admin::toString()
     */
    public function toString($object)
    {
        return $object instanceof BaseAsset && $object->getName()
        ? $object->getName()
        : $this->trans('link_add', array(), 'SonataAdminBundle');
    }
    
    /**
     * Replaces textarea with code mirror input
     */
    public function enableCodeMirror()
    {
        $this->codeMirrorEnabled = true;
    }
    
    /**
     * Uses plain textarea
     */
    public function disableCodeMirror()
    {
        $this->codeMirrorEnabled = false;
    }
    
    /**
     * @return array
     */
    protected function getCodeMirrorParams()
    {
        return array();
    }
    
    /**
     * {@inheritdoc}
     * @see \Sonata\AdminBundle\Admin\Admin::getNewInstance()
     */
    public function getNewInstance()
    {
        /* @var $object BaseAsset */
        $object = parent::getNewInstance();
        $object->setParentDocument($this->getModelManager()->find(null, $this->getRootPath()));
    
        return $object;
    }
    
}