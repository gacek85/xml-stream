<?php
namespace Gacek85\XML\Node\Event\Providers;

use Gacek85\XML\Node\Event\EndEvent;
use Gacek85\XML\Node\Event\ProviderAwareInterface;

/**
 *  End event provider
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class EndEventProvider extends AbstractEventProvider 
{
    
    /**
     * Creates the end event 
     * 
     * 
     * @param       array               $params
     * 
     * @return      Event
     */
    public function createEvent(array $params)
    {
        return new EndEvent($this->validate($params, 'totalNodes'));
    }

    /**
     * Returns event name
     * 
     * @return      string
     */
    public function getName()
    {
        return ProviderAwareInterface::NAME_END;
    }

}