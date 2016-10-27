<?php
namespace Gacek85\XML\Test;

use Gacek85\XML\Mock\Chunk\ProviderMock;
use Gacek85\XML\Mock\Node\Event\Feature\ProviderMock as FeatureProviderMock;
use Gacek85\XML\Node\Detector;
use Gacek85\XML\Node\Event\Aggregator;
use Gacek85\XML\Node\Event\NodeEvent;
use Gacek85\XML\Node\Event\Providers\EndEventProvider;
use Gacek85\XML\Node\Event\Providers\NodeEventProvider;
use Gacek85\XML\Node\Event\Providers\StartEventProvider;
use Gacek85\XML\Stream;
use PHPUnit_Framework_TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 *  Test case for NodeDetector
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class StreamTest extends PHPUnit_Framework_TestCase 
{
    
    /**
     *
     * @var Stream
     */
    protected $stream = null;
    
    
    protected function setUp()
    {
        $this->stream = $this->createStream();
    }
    
    
    protected function createStream()
    {
        return new Stream(
            new EventDispatcher(), 
            $this->createChunkProvider(), 
            $this->createNodeDetector(), 
            $this->createEventProvider()
        );
    }
    
    
    protected function createChunkProvider()
    {
        return new ProviderMock();
    }
    
    
    protected function createNodeDetector()
    {
        return new Detector();
    }
    
    protected function createEventProvider()
    {
        return (new Aggregator())
                ->addProvider($this->createNodeEventProvider())
                ->addProvider(new StartEventProvider())
                ->addProvider(new EndEventProvider());
    }
    
    
    protected function createNodeEventProvider()
    {
        return (new NodeEventProvider())
                    ->addFeatureProvider(new FeatureProviderMock());
    }
    
    
    public function testRead()
    {
        $counter = 0;
        
        $hasStart = $hasEnd = false;
        
        $this
            ->stream
            ->getDispatcher()
            ->addListener('xml_stream.start', function (\Gacek85\XML\Node\Event\StartEvent $ev) use (&$hasStart) {
                $this->assertEquals('item', $ev->getNodeName());
                $hasStart = true;
            });
        
        $this
            ->stream
            ->getDispatcher()
            ->addListener('xml_stream.end', function (\Gacek85\XML\Node\Event\EndEvent $ev) use (&$hasEnd) {
                $this->assertEquals(ProviderMock::MAX_CHUNKS, $ev->getTotalNodes());
                $hasEnd = true;
            });
        
        $this
            ->stream
            ->getDispatcher()
            ->addListener('xml_stream.node', function (NodeEvent $ev) use (&$counter) {
                $counter++;
            });
        
        $this->stream->read('item');
        $this->assertEquals(ProviderMock::MAX_CHUNKS, $counter);
        $this->assertTrue($hasEnd);
        $this->assertTrue($hasStart);
    }
}