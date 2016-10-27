<?php
namespace Gacek85\XML\Test\Node\Event;

use Gacek85\XML\Node\Event\NodeEvent;
use PHPUnit_Framework_TestCase;

/**
 *  Abstraction for Event aware tests
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
abstract class AbstractEventAwareTest extends PHPUnit_Framework_TestCase 
{

    const DEFAULT_COUNTER = 2;

    /**
     * Provides event instance
     * 
     * @return      NodeEvent
     */
    protected function getEvent($counter = self::DEFAULT_COUNTER)
    {
        return new NodeEvent($counter, 'item', $this->getRawNode());
    }
    
    
    protected function getRawNode ()
    {
        return file_get_contents(sprintf(
            '%s/../../../../Resources/xml/unit/full_node.txt',
            __DIR__
        ));
    }
}