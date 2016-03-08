<?php
namespace NVBooster\PHPCRAssetsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Assetic\Asset\StringAsset;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\AsseticBundle\FilterManager;

/**
 * AssetController
 *
 * @author nvb <nvb@aproxima.ru>
 */
class AssetController
{
    /**
     * @var FilterManager
     */
    private $filterManager;
    
    /**
     * @var boolean
     */
    private $isDebug = false; 
    
    /**
     * @var array
     */
    private $cssFilters = array();
    
    /**
     * @var array
     */
    private $jsFilters = array();
     
    /**
     * @param KernelInterface $kernel
     * @param array           $filters
     */
    public function __construct(FilterManager $filterManager, KernelInterface $kernel = null, $filters = null)
    {
        if ($kernel) {
            $this->isDebug = $kernel->isDebug();
        }
        
        if (is_array($filters)) {
            if (key_exists('js', $filters)) {
                if (is_array($filters['js'])) {
                    $this->jsFilters = $filters['js'];
                }
            }
            if (key_exists('css', $filters)) {
                if (is_array($filters['css'])) {
                    $this->jsFilters = $filters['css'];
                }
            }
        }
    }
    
    /**
     * @param Request $request
     * @param object  $assetDocument
     * @param array   $filters
     *
     * @return Response
     */
    public function serveAsset(Request $request, $contentDocument, $filters = array())
    {

        $response = new Response();
        $response->setStatusCode(200);
        $response->setLastModified($contentDocument->getUpdatedAt());
        $response->setPublic();

        if (!$this->isDebug && $response->isNotModified($request)) {
            return $response;
        }

        $asset = new StringAsset($contentDocument->getContent());
        $asset->load();

        foreach ($filters as $filter) {
            if (($filter[0] !== '?') || (!$this->isDebug)) {
                if ($processor = $this->filterManager->get(preg_replace('@^\?@', '', $filter))) {
                    $processor->filterDump($asset);
                }
            }
        }

        $response->setContent($asset->getContent());

        $response->prepare($request);

        return $response;
    }

    /**
     * Helper action
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param array   $filters
     *
     * @return Response
     */
    public function serveJs(Request $request, $contentDocument, $filters = array())
    {
        if ($filters === false) {
            $mergedFilters = array();
        } elseif ($filters) {
            $mergedFilters = $filters;
        } else {
            $mergedFilters = $this->jsFilters;
        }
        
        $response = $this->serveAsset($request, $contentDocument, $mergedFilters);
        $response->headers->set('Content-Type', 'text/javascript');
        
        return $response;
    }

    /**
     * Helper action
     *
     * @param Request $request
     * @param object  $contentDocument
     * @param array   $filters
     *
     * @return Response
     */
    public function serveCss(Request $request, $contentDocument, $filters = array())
    {
        if ($filters === false) {
            $mergedFilters = array();
        } elseif ($filters) {
            $mergedFilters = $filters;
        } else {
            $mergedFilters = $this->cssFilters;
        }
        
        $response = $this->serveAsset($request, $contentDocument, $mergedFilters);
        $response->headers->set('Content-Type', 'text/css');
        
        return $response;
    }
}