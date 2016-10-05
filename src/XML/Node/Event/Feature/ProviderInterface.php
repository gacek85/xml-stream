<?php
namespace Gacek85\XML\Node\Event\Feature;

use Gacek85\XML\Node\Event\Event;

/**
 *  ProviderInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface ProviderInterface 
{
    /**
     * Provides the feature name parser is able to extract from
     * the node 
     * 
     * @return      string
     */
    public function getFeature();
    
    
    /**
     * Returns node feature
     * 
     * @param       Event           $nodeEvent
     */
    public function provide(Event $nodeEvent);
            
}