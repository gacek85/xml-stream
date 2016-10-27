<?php
namespace Gacek85\XML\Mock\Node\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 *  Mock implementation of Event
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class EventMock extends Event 
{
    
    protected $params = null;
    
    
    public function __construct(array $params)
    {
        $this->params = $params;
    }
    
    
    /**
     * Returns the related params
     * 
     * @return      array
     */
    public function getParams()
    {
        return $this->params;
    }
}