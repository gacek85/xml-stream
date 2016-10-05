<?php
namespace Gacek85\XML\Node\Event;

/**
 *  Provides event for given node
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface ProviderInterface 
{
    /**
     * Creates the event for given node
     * 
     * @param       int                 $counter
     * 
     * @param       string              $node
     * 
     * @param       string              $nodeName
     * 
     * @return      ProviderInterface   This instance
     */
    public function createEvent($counter, $node, $nodeName);
}