<?php
namespace Gacek85\XML\Node\Event\Providers;

use Gacek85\XML\Node\Event\ProviderAwareInterface;
use Gacek85\XML\Node\Event\StartEvent;

/**
 *  Start event provider
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class StartEventProvider extends AbstractEventProvider 
{
    
    /**
     * Creates the start event 
     * 
     * 
     * @param       array               $params
     * 
     * @return      Event
     */
    public function createEvent(array $params)
    {
        return new StartEvent($this->validate($params, 'nodeName'));
    }

    /**
     * Returns event name
     * 
     * @return      string
     */
    public function getName()
    {
        return ProviderAwareInterface::NAME_START;
    }

}