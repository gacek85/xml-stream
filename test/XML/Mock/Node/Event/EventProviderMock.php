<?php
namespace Gacek85\XML\Mock\Node\Event;

use Gacek85\XML\Node\Event\ProviderInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 *  Mock implementation of \Gacek85\XML\Node\Event\ProviderInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class EventProviderMock implements ProviderInterface 
{

    const NAME = "mock";

    /**
     * Returns event name
     * 
     * @return      string
     */
    public function getName()
    {
        return self::NAME;
    }
    
    
    /**
     * Creates the event 
     * 
     * 
     * @param       array               $params
     * 
     * @return      Event
     */
    public function createEvent(array $params)
    {
        return new EventMock($params);
    }
}