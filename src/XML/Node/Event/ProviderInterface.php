<?php
namespace Gacek85\XML\Node\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 *  Provides event for given node
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface ProviderInterface 
{
    
    /**
     * Returns event name
     * 
     * @return      string
     */
    public function getName();
    
    
    /**
     * Creates the event 
     * 
     * 
     * @param       array               $params
     * 
     * @return      Event
     */
    public function createEvent(array $params);
}