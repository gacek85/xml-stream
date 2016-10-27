<?php
namespace Gacek85\XML\Node\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

/**
 *  Start event implementation
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class StartEvent extends BaseEvent
{
        
    protected $nodeName = null;
        
    
    /**
     * Constructs the event
     * 
     * @param       string      $nodeName
     */
    public function __construct($nodeName)
    {
        $this->nodeName = $nodeName;
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
}