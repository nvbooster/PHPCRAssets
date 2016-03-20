<?php
namespace NVBooster\PHPCRAssetsBundle\Twig;

/**
 * @author nvb
 *
 */
class PHPCRAssetsExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $jsPath;
    /**
     * @var string
     */
    private $cssPath;
    /**
     * @var string
     */
    private $modesDir;
    /**
     * @var string
     */
    private $themesDir;

    /**
     * @var array
     */
    private $rendered;

    /**
     * @param array $paths
     */
    public function __construct($paths = array())
    {
        $this->jsPath = key_exists('js', $paths) ? $paths['js'] : false;
        $this->cssPath = key_exists('css', $paths) ? $paths['css'] : false;
        $this->modesDir = key_exists('modes_dir', $paths) ? $paths['modes_dir'] : false;
        $this->themesDir = key_exists('themes_dir', $paths) ? $paths['themes_dir'] : false;

        $this->rendered = array();
    }

    /**
     * {@inheritDoc}
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('phpcrassets_codemirror_params', array($this, 'parametersRender'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('phpcrassets_codemirror_css', array($this, 'getCss')),
            new \Twig_SimpleFunction('phpcrassets_codemirror_js', array($this, 'getJs')),
        );
    }

    /**
     * @param array $parameters
     */
    public function parametersRender($parameters)
    {
        return json_encode($parameters);
    }

    /**
     * @param array  $parameters
     * @param string $force
     *
     * @return array
     */
    public function getJs($parameters, $force = false)
    {
        $urls = array();

        if ($this->jsPath) {
            $urls[] = $this->jsPath;
        }

        if ($this->modesDir) {
            $urls[] = preg_replace('@\/$@', '', $this->modesDir) . '/' . $parameters['mode'] . '/' . $parameters['mode'] . '.js';
        }


        if (!$force) {
            $urls = array_diff($urls, $this->rendered);
        }

        $this->rendered = array_unique(array_merge($this->rendered, $urls));

        return $urls;
    }

    /**
     * @param array  $parameters
     * @param string $force
     *
     * @return array
     */
    public function getCss($parameters, $force = false)
    {
        $urls = array();

        if ($this->cssPath) {
            $urls[] = $this->cssPath;
        }

        if ($this->modesDir) {
            $urls[] = preg_replace('@\/$@', '', $this->themesDir) . '/' . $parameters['theme'] . '.css';
        }


        if (!$force) {
            $urls = array_diff($urls, $this->rendered);
        }

        $this->rendered = array_unique(array_merge($this->rendered, $urls));

        return $urls;
    }

    /**
     * {@inheritDoc}
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'phpcrassets_extension';
    }
}
