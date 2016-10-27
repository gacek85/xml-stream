<?php
namespace Gacek85\XML\Test\Node\Event;

use Gacek85\XML\Mock\Node\Event\EventMock;
use Gacek85\XML\Mock\Node\Event\EventProviderMock;
use Gacek85\XML\Node\Event\Aggregator;
use PHPUnit_Framework_TestCase;

/**
 *  Aggregator test case
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class AggregatorTest extends PHPUnit_Framework_TestCase 
{
    
    public function testAggregator()
    {
        $aggregator = $this->getAggregator();
        $aggregator->useProvider(EventProviderMock::NAME);
        $this->assertEquals('xml_stream.' . EventProviderMock::NAME, $aggregator->getName());
        $event = $aggregator->createEvent([
            'some' => 'value'
        ]);
        
        $this->assertInstanceOf(EventMock::class, $event);
    }
    
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAggregatorNonExistingException()
    {
        $aggregator = $this->getAggregator();
        $aggregator->getProvider('non_existing');
    }
    
    
    /**
     * @expectedException \RuntimeException
     */
    public function testAggregatorNoCurrentException()
    {
        $aggregator = $this->getAggregator();
        $aggregator->createEvent([]);
    }
    
    
    protected function getAggregator()
    {
        return (new Aggregator())->addProvider(new EventProviderMock());
    }
}