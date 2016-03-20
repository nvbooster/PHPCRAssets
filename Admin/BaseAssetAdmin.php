<?php
namespace NVBooster\PHPCRAssetsBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use NVBooster\PHPCRAssetsBundle\Asset\BaseAsset;
use NVBooster\PHPCRAssetsBundle\Asset\CssAsset;
use NVBooster\PHPCRAssetsBundle\Asset\JsAsset;
use PHPCR\Util\UUIDHelper;
use PHPCR\Util\PathHelper;

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
     * @var array
     */
    protected $codeMirrorParams = array();

    /**
     * {@inheritDoc}
     *
     * @see \Sonata\AdminBundle\Admin\Admin::configureListFields()
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->addIdentifier('name', 'text')
            ->addIdentifier('extension', 'text');

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

        $asset = $this->getSubject();

        if ($this->codeMirrorEnabled) {
            $codeMirrorParams = $this->getCodeMirrorParams();
            if ($asset instanceof JsAsset) {
                $codeMirrorParams['lineNumbers'] = true;
                $codeMirrorParams['mode'] = 'javascript';
            } elseif ($asset instanceof CssAsset) {
                $codeMirrorParams['lineNumbers'] = true;
                $codeMirrorParams['mode'] = 'css';
            }

            $group->add('content', 'textasset', array(
                'required' => false,
                'codemirror' => $codeMirrorParams
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
    public function getCodeMirrorParams()
    {
        return $this->codeMirrorParams;
    }

    /**
     * @param $params array
     */
    public function setCodeMirrorParams(array $params)
    {
        $this->codeMirrorParams = $params;
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

    /**
     * @{inheritdocs}
     *
     * @see https://github.com/sonata-project/SonataDoctrinePhpcrAdminBundle/issues/354
     */
    public function getSubject()
    {
        if ($this->subject === null && $this->request) {
            $id = $this->request->get($this->getIdParameter());
            if (!preg_match('#^[0-9A-Za-z/\-_]+$#', $id)) {
                $this->subject = false;
            } else {
                if (!UUIDHelper::isUUID($id)) {
                    $id = PathHelper::absolutizePath($id, '/');
                }
                $this->subject = $this->getModelManager()->find(null, $id);
            }
        }

        return $this->subject;
    }

}