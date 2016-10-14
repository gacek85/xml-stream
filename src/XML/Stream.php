<?php
namespace Gacek85\XML;

use Gacek85\XML\Chunk\ProviderInterface as ChunkProviderInterface;
use Gacek85\XML\Node\DetectorInterface;
use Gacek85\XML\Node\Event\ProviderInterface as EventProviderInterface;
use Gacek85\XML\Node\Event\EventInterface as NodeEventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 *  Event streamtream provider for XML file nodes. 
 *  Reads the file chunk by chunk and dispatches events
 *  containing matching nodes information.
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class Stream 
{
    
    protected $nodeName = null;

    /**
     *
     * @var EventDispatcherInterface
     */
    protected $dispatcher = null;

    
    /**
     *
     * @var DetectorInterface
     */
    protected $nodeDetector = null;
    
    
    /**
     *
     * @var ChunkProviderInterface
     */
    protected $chunkProvider = null;
    
    
    /**
     *
     * @var EventProviderInterface
     */
    protected $eventProvider = null;
    
    
    protected $counter = 0;
    

    public function __construct(
        EventDispatcherInterface $dispatcher, 
        ChunkProviderInterface $chunkProvider,
        DetectorInterface $nodeDetector,
        EventProviderInterface $eventProvider
    ){
        $this->dispatcher = $dispatcher;
        $this->chunkProvider = $chunkProvider;
        $this->nodeDetector = $nodeDetector;
        $this->eventProvider = $eventProvider;
    }
    
    /**
     * Reads the XML file and dispatches nodes 
     * events for every detected node
     * 
     * @param       string      $nodeName
     */
    public function read($nodeName)
    {
        $this->counter = 0;
        $this->nodeName = $nodeName;
        $this->chunkProvider->reset();
        $this
            ->nodeDetector
            ->reset()
            ->setNodeName($nodeName);
        
        $this->doRead();       
    }
    
    
    protected function doRead()
    {
        while ($this->chunkProvider->hasChunk()) {
            $this->processChunk($this->chunkProvider->getChunk());
        }
    }
    
    
    protected function processChunk($chunk)
    {
        if ($this->nodeDetector->hasNodes($chunk)) {
            $this->processNodes($this->nodeDetector->getNodesText());
        }
    }
    
    
    protected function processNodes(array $nodes)
    {
        array_map(function ($node) {
            $this
                ->getDispatcher()
                ->dispatch(
                    NodeEventInterface::NAME, 
                    $this->eventProvider->createEvent(
                        $this->increaseCounter(), 
                        $this->nodeName, 
                        $node
                    )
                );
        }, $nodes);
    }
    
    
    /**
     * Increases the counter of found nodes
     * 
     * @return      int
     */
    public function increaseCounter()
    {
        return ++$this->counter;
    }
    
    
    /**
     * Returns the related event dispatcher
     * 
     * @return      EventDispatcherInterface
     */
    public function getDispatcher ()
    {
        return $this->dispatcher;
    }
}