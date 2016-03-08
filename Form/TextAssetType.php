<?php
namespace NVBooster\PHPCRAssetsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * @author nvb
 *
 */
class TextAssetType extends AbstractType
{
    /**
     * @var array
     */
    protected $parameters;
    
    /**
     * @param array $defaultsParameters
     */
    public function __construct($defaultsParameters = array())
    {
        $this->parameters = $defaultsParameters;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['codemirror'] = array_merge($this->parameters, $options['codemirror']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'codemirror' => $this->parameters
            )
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextareaType::class;
    }
    
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'textasset';
    }
}