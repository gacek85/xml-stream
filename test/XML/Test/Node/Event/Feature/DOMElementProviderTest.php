<?php
namespace Gacek85\XML\Test\Node\Event\Feature;

use Gacek85\XML\Node\Event\Event;
use Gacek85\XML\Node\Event\Feature\DOMElementProvider;
use PHPUnit_Framework_TestCase;

/**
 *  Test case for DOMElementProvider
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class DOMElementProviderTest extends PHPUnit_Framework_TestCase 
{
    
    public function testProvide()
    {
        $provider = new DOMElementProvider();
        $this->assertEquals(DOMElementProvider::FEATURE, $provider->getFeature());
        
        $event = $this->getEvent();
        
        $this->assertEquals($this->getRawNode(), $event->getRawNode());
        $this->assertEquals(2, $event->getCounter());
        $this->assertEquals('item', $event->getNodeName());

        $event->addFeature(DOMElementProvider::FEATURE, $provider->provide($event));
        $this->assertInstanceOf('\DOMElement', $event->getFeature(DOMElementProvider::FEATURE));
    }
    
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Feature `non_exisiting_feature` does not exist!
     */
    public function testExpectedException()
    {
        $event = $this->getEvent();
        $event->getFeature('non_exisiting_feature');
    }
    
    
    protected function getEvent()
    {
        return new Event(2, 'item', $this->getRawNode());
    }
    
    
    protected function getRawNode ()
    {
        return file_get_contents(sprintf(
            '%s/../../../../../Resources/xml/full_node.txt',
            __DIR__
        ));
    }
    
}