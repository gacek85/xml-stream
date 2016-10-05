<?php
namespace Gacek85\XML\Node\Event;

/**
 *  Losely defined interface for node event
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface EventInterface 
{
    const NAME = 'xml_stream.node';
    
    /**
     * Provides the raw node
     * 
     * @return string
     */
    public function getRawNode();
    
    
    /**
     * Returns the name of the node
     * 
     * @return      string
     */
    public function getNodeName();
    
    
    /**
     * Returns node counter
     * 
     * @return      int
     */
    public function getCounter();
}