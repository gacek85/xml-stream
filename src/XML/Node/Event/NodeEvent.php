<?php
namespace Gacek85\XML\Node\Event;

use InvalidArgumentException;
use Symfony\Component\EventDispatcher\Event as BaseEvent;

/**
 *  Node event implementation
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class NodeEvent extends BaseEvent
{
    
    protected $counter = null;
    
    
    protected $rawNode = null;
    
    
    protected $nodeName = null;
    
    
    /**
     *
     * @var array|mixed[]
     */
    protected $features = [];
    
    
    /**
     * 
     * @param       int         $counter
     * 
     * @param       string      $nodeName
     * 
     * @param       string      $rawNode
     */
    public function __construct($counter, $nodeName, $rawNode)
    {
        $this->counter = $counter;
        $this->nodeName = $nodeName;
        $this->rawNode = $rawNode;
    }
    
    
    /**
     * Returns node counter
     * 
     * @return      int
     */
    public function getCounter()
    {
        return $this->counter;
    }

    
    /**
     * Returns the name of the node
     * 
     * @return      string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }
    
    
    /**
     * Provides the raw node
     * 
     * @return      string
     */
    public function getRawNode()
    {
        return $this->rawNode;
    }

    
    /**
     * Adds a feature for that node
     * 
     * @param       string      $feature
     * 
     * @param       mixed       $value
     * 
     * @return      NodeEvent   This event
     */
    public function addFeature($feature, $value)
    {
        $this->features[$feature] = $value;
        return $this;
    }
    
    
    /**
     * Gets the feature value
     * 
     * @param       string      $feature
     * 
     * @return      mixed
     * 
     * @throws      InvalidArgumentException
     */
    public function getFeature($feature)
    {
        if (!array_key_exists($feature, $this->features)) {
            throw new InvalidArgumentException(sprintf(
                'Feature `%s` does not exist!',
                $feature
            ));
        }
        
        return $this->features[$feature];
    }
}