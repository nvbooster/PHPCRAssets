<?php
namespace NVBooster\PHPCRAssetsBundle\Asset;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

/**
 * @author nvb
 *
 */
class BaseAsset implements RouteReferrersReadInterface
{
    /**
     * @var string
     */
    protected $id;
    
    /**
     * @var object
     */
    protected $parentDocument;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $content;
    
    /**
     * @var \DateTime
     */
    protected $updatedAt;
    
    /**
     * @var array
     */
    protected $routes;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return BaseAsset
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * @return object
     */
    public function getParentDocument()
    {
        return $this->parentDocument;
    }

    /**
     * @param object $parentDocument
     * 
     * @return BaseAsset
     */
    public function setParentDocument($parentDocument)
    {
        $this->parentDocument = $parentDocument;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * 
     * @return BaseAsset
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * 
     * @return BaseAsset
     */
    public function setContent($content)
    {
        $this->content = $content;
        
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * 
     * @return BaseAsset
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getExtension()
    {
        return '';
    }
    
    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}