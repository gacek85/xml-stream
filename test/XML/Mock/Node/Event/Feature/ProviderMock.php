<?php
namespace Gacek85\XML\Mock\Node\Event\Feature;

use Gacek85\XML\Node\Event\NodeEvent as Event;
use Gacek85\XML\Node\Event\Feature\ProviderInterface;


/**
 *  Mock for feature provider
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class ProviderMock implements ProviderInterface
{

    const FEATURE = "test_feature";
    
    const TEST_VALUE = "test_value";

    /**
     * Provides the feature name parser is able to extract from
     * the node 
     * 
     * @return      string
     */
    public function getFeature()
    {
        return self::FEATURE;
    }
    
    
    /**
     * Returns node feature
     * 
     * @param       Event           $nodeEvent
     */
    public function provide(Event $nodeEvent)
    {
        return self::TEST_VALUE;
    }
}