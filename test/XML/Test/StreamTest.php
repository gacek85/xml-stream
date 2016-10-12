<?php
namespace Gacek85\XML\Test;

use Gacek85\XML\Mock\Chunk\ProviderMock;
use Gacek85\XML\Mock\Node\Event\Feature\ProviderMock as FeatureProviderMock;
use Gacek85\XML\Node\Detector;
use Gacek85\XML\Node\Event\Event;
use Gacek85\XML\Node\Event\EventInterface;
use Gacek85\XML\Node\Event\Provider;
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
            $this->createNodeProvider()
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
    
    
    protected function createNodeProvider()
    {
        return (new Provider())
                    ->addFeatureProvider(new FeatureProviderMock());
    }
    
    
    public function testRead()
    {
        $counter = 0;
        $this
            ->stream
            ->getDispatcher()
            ->addListener(EventInterface::NAME, function (Event $ev) use (&$counter) {
                $counter++;
            });
        
        $this->stream->read('item');
        $this->assertEquals(ProviderMock::MAX_CHUNKS, $counter);
    }
}