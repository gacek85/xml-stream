<?php
namespace Gacek85\XML\Node;

/**
 *  Detects given node in incoming chunks
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface DetectorInterface 
{
    /**
     * Sets node that the detector will look for in the chunks
     * 
     * @param       string                      $nodeName
     * 
     * @return      DetectorInterface           This instance
     */
    public function setNodeName($nodeName);
    
    
    /**
     * Resets the detector
     * 
     * @return      DetectorInterface           This instance
     */
    public function reset();
    
    
    /**
     * Returns bool if preset node has been detected at least once in the stream 
     * of chunks
     * 
     * @param       string          $chunk
     * @return      bool
     */
    public function hasNodes($chunk);
    
    
    /**
     * Returns an array of node strings that represents full XML node
     * 
     * @return      array
     */
    public function getNodesText();
}