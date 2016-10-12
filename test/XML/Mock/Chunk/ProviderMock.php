<?php
namespace Gacek85\XML\Mock\Chunk;

use Gacek85\XML\Chunk\ProviderInterface;

/**
 *
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class ProviderMock implements ProviderInterface
{
    const MAX_CHUNKS = 100;
    
    protected $counter = 0;
    
    /**
     * Defines if is able to provide more chunks of
     * data
     * 
     * @return      bool
     */
    public function hasChunk()
    {
        return ($this->counter++ < self::MAX_CHUNKS);
    }
    
    
    /**
     * Checks if is end of file
     * 
     * @return      bool
     */
    public function isEof()
    {
        return !$this->hasChunk();
    }
    
    
    /**
     * Returns a chunk string of data. If no data available,
     * throws 
     * 
     * @return      string
     * 
     * @throws      EofException
     */
    public function getChunk()
    {
        return file_get_contents(sprintf(
            '%s/../../../Resources/xml/unit/full_node.txt',
            __DIR__
        ));
    }
    
    
    /**
     * Resets the provider to the beginning of the file
     * 
     * @return      ProviderInterface   This instance
     * 
     * @throws      LogicException      If first chunk can't be loaded
     */
    public function reset()
    {
        $this->counter = 0;
    }
}