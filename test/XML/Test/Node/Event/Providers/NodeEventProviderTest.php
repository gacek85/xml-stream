<?php
namespace Gacek85\XML\Test\Node\Event;

use Gacek85\XML\Mock\Node\Event\Feature\ProviderMock;
use Gacek85\XML\Node\Event\NodeEvent;
use Gacek85\XML\Node\Event\Providers\NodeEventProvider as Provider;
use Gacek85\XML\Test\Node\Event\AbstractEventAwareTest;

/**
 *  Test case for NodeEventProvider
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class NodeEventProviderTest extends AbstractEventAwareTest 
{
    /**
     *
     * @var Provider
     */
    protected $provider = null;
    
    protected function setUp()
    {
        $this->provider = new Provider();
    }


    public function testCreateEvent()
    {
        $instance = $this->provider->addFeatureProvider(new ProviderMock());
        $this->assertSame($this->provider, $instance);
        $event = $this->provider->createEvent([
            'counter' => 1, 
            'nodeName' => 'item', 
            'node' => $this->getRawNode()
        ]);
        
        $this->assertInstanceOf(NodeEvent::class, $event);
        $this->assertEquals(1, $event->getCounter());
        $this->assertEquals($this->getRawNode(), $event->getRawNode());
        $this->assertEquals($event->getFeature(ProviderMock::FEATURE), ProviderMock::TEST_VALUE);
        
        $throwsError = false;
        try {
            $this->provider->addFeatureProvider(new ProviderMock());
        } catch (\InvalidArgumentException $ex) {
            $throwsError = true;
            $this->assertEquals(sprintf('Feature provider for `%s` already exists.', ProviderMock::FEATURE), $ex->getMessage());
        }
        $this->assertTrue($throwsError);        
    }    
    
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateEventException()
    {
        $this->provider->createEvent([ 
            'nodeName' => 'item', 
            'node' => ''
        ]);
    }
}