<?php
namespace Gacek85\XML\Test\Node\Event\Feature;

use Gacek85\XML\Node\Event\Feature\DOMElementProvider;
use Gacek85\XML\Test\Node\Event\AbstractEventAwareTest;

/**
 *  Test case for DOMElementProvider
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class DOMElementProviderTest extends AbstractEventAwareTest
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
}