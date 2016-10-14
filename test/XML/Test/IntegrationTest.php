<?php
namespace Gacek85\XML\Test;

use Faker\Factory;
use Gacek85\XML\Chunk\Provider as ChunkProvider;
use Gacek85\XML\Node\Detector;
use Gacek85\XML\Node\Event\Event;
use Gacek85\XML\Node\Event\EventInterface;
use Gacek85\XML\Node\Event\Feature\DOMElementProvider;
use Gacek85\XML\Node\Event\Provider as EventProvider;
use Gacek85\XML\Stream;
use Gacek85\XML\Test\Tools\XmlGenerator;
use PHPUnit_Framework_TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 *  Integration test for all the components working together
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class IntegrationTest extends PHPUnit_Framework_TestCase 
{

    /**
     *
     * @var Stream
     */
    protected $stream = null;
    
    protected $filePath = null;
    
    protected $nodeName = null;


    protected function up($nodesCount, $chunkLength)
    {
        list($this->nodeName, $this->filePath) = $this->setUpXml($nodesCount);
        $this->stream = $this->createStream($chunkLength);
    }
    
    
    protected function createStream($chunkLength)
    {
        return new Stream(
            new EventDispatcher(), 
            new ChunkProvider($this->filePath, $chunkLength), 
            new Detector(), 
            $this->createEventProvider()
        );
    }
    
    
    protected function createEventProvider()
    {
        return (new EventProvider())
                    ->addFeatureProvider(new DOMElementProvider());
    }
 
    
    protected function setUpXml($nodesCount)
    {
        return [
            $nodeName = $this->getFaker()->word,
            $this->doSetupXml($nodeName, $nodesCount)
        ];
    }
    
    
    protected function doSetupXml($nodeName, $nodesCount)
    {
        $path = $this->getFilePath();
        (new XmlGenerator($nodesCount, $nodeName, $this->getFaker()))->generate($path);
        
        return $path;
    }
    
    
    protected function getFilePath()
    {
        return sprintf(
            '%s/../../Resources/xml/integration/%s.xml',
            __DIR__,
            $this->getFaker()->word
        );
    }
    
    
    public function getFaker()
    {
        return Factory::create();
    }
    
    
    public function testRead()
    {
        array_map(function ($nodesCount) {
            $this->singleTest($nodesCount);
        }, $this->getNodesCounts());
    }
    
    
    protected function singleTest($nodesCount)
    {
        array_map(function($chunkLength) use ($nodesCount) {
            $this->doSingleTest($nodesCount, $chunkLength);
        }, $this->getChunkLengths());
    }
    
    
    protected function doSingleTest($nodesCount, $chunkLength)
    {
        $this->up($nodesCount, $chunkLength);
        
        $counter = 0;
        $this
            ->stream
            ->getDispatcher()
            ->addListener(EventInterface::NAME, function (Event $ev) use (&$counter) {
                $this->assertEquals(++$counter, $ev->getCounter(), $ev->getRawNode());
                $this->assertEquals($this->nodeName, $ev->getNodeName());
                $this->assertInstanceOf(\DOMElement::class, $ev->getFeature(DOMElementProvider::FEATURE));
            });
        
        $this->stream->read($this->nodeName);
        $this->assertEquals($nodesCount, $counter);
        
        $this->down();
    }
    
    
    protected function getChunkLengths()
    {
        return [
            1000, 100, 10, 2
        ];
    }
    
    
    protected function getNodesCounts()
    {
        return [
            10, 100, 1000
        ];
    }
    
    
    protected function down()
    {
        $this->doTearDown();
        $this->filePath = null;
        $this->nodeName = null;
        $this->stream = null;
    }
    
    
    protected function tearDown()
    {
        $this->doTearDown();
    }
    
    
    protected function doTearDown()
    {
        $globPath = sprintf(
            '%s/*.xml', 
            pathinfo($this->getFilePath(), PATHINFO_DIRNAME)
        );
        
        array_map(function ($filePath) {
            unlink($filePath);
        }, glob($globPath));
    }
}