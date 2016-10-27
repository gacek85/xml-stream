<?php
namespace Gacek85\XML\Node\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

/**
 *  End event implementation
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class EndEvent extends BaseEvent
{
        
    protected $totalNodes = null;
        
    
    /**
     * Constructs the event
     * 
     * @param       int      $totalNodes
     */
    public function __construct($totalNodes)
    {
        $this->totalNodes = $totalNodes;
    }
    
    
    /**
     * Returns the name of the node
     * 
     * @return      string
     */
    public function getTotalNodes()
    {
        return $this->totalNodes;
    }
}