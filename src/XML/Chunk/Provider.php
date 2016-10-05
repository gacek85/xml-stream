<?php
namespace Gacek85\XML\Chunk;

use Gacek85\XML\Exception\EofException;
use LogicException;
use RuntimeException;
use SplFileObject;

/**
 *  Default implementation of ProviderInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class Provider implements ProviderInterface
{

    const DEFAULT_CHUNK_LENGTH = 1024;

    /**
     *
     * @var SplFileObject
     */
    protected $file = null;
    
    protected $path = null;
    
    protected $isStarted = false;
    
    protected $chunk = null;
    
    
    /**
     * Constructs the reader
     * 
     * @param       string      $resourcePath
     */
    public function __construct(
        $resourcePath, 
        $chunkLength = self::DEFAULT_CHUNK_LENGTH
    )
    {
        $this->path = $resourcePath;
        $this->chunkLength = $chunkLength;
    }
    
    
    /**
     * Resets the provider to the beginning of the file
     * 
     * @return      Provider            This instance
     * 
     * @throws      LogicException      If first chunk can't be loaded
     */
    public function reset()
    {
        try {
            $this->file = new SplFileObject($this->path, 'r');
        } catch (RuntimeException $ex) {
            throw new LogicException(sprintf(
                'Did not manage to load the initial chunk of data from file `%s`',
                $this->path
            ), null, $ex);
        }
        $this->next()->isStarted = true;
        
        return $this;
    }
    
    
    /**
     * Defines if is able to provide more chunks of
     * data
     * 
     * @return      bool
     */
    public function hasChunk()
    {
        return $this->init()->doesHaveChunk();
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
        return $this->init()->doGetChunk();
    }
    
    
    /**
     * Initiates the reader if needed
     * 
     * @return      Reader      This instance
     */
    protected function init()
    {
        if (!$this->isStarted) {
            return $this->reset();
        }
        
        return $this;
    }
    
    
    
    /**
     * Returns boolean representation of loaded chunk
     * 
     * @return      bool
     */
    protected function doesHaveChunk()
    {
        return (bool)$this->chunk;
    }
    
    
    protected function doGetChunk()
    {
        if (!($chunk = $this->chunk)) {
            throw new EofException('Next chunk is not available');
        }
        $this->next();
        
        return $chunk;
    }
    
    /**
     * Loads next chunk
     * 
     * @return      Reader      This instance
     */
    protected function next()
    {
        $this->chunk = $this->file->fread($this->chunkLength);
        return $this;
    }
}