<?php
namespace Gacek85\XML\Chunk;

use Gacek85\XML\Exception\EofException;
use LogicException;

/**
 *  Provides chunks of data and information, if is
 *  able to provide more.
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface ProviderInterface
{
    /**
     * Defines if is able to provide more chunks of
     * data
     * 
     * @return      bool
     */
    public function hasChunk();
    
    
    /**
     * Checks if is end of file
     * 
     * @return      bool
     */
    public function isEof();
    
    
    /**
     * Returns a chunk string of data. If no data available,
     * throws 
     * 
     * @return      string
     * 
     * @throws      EofException
     */
    public function getChunk();
    
    
    /**
     * Resets the provider to the beginning of the file
     * 
     * @return      ProviderInterface   This instance
     * 
     * @throws      LogicException      If first chunk can't be loaded
     */
    public function reset();
}