<?php
namespace Gacek85\XML\Node\Event;

use InvalidArgumentException;

/**
 *  Provides additional methods to the NodeEventInterface 
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface ExtendedEventInterface extends EventInterface 
{
    /**
     * Gets additional feature value
     * 
     * @param       string      $feature
     * 
     * @return      mixed
     * 
     * @throws      InvalidArgumentException
     */
    public function getFeature($feature);
}