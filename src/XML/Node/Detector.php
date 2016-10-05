<?php
namespace Gacek85\XML\Node;

use RuntimeException;


/**
 *  Default implementation for DetectorInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class Detector implements DetectorInterface 
{

    const REGEX_PATTERN = <<<EOR
                /\<:node:((?!\<\/:node:\>)).+?\<\/:node:\>/s
EOR;

    protected $nodeName = null;
    
    protected $acc = '';
    
    protected $lastChunk = '';
    
    protected $rawNodes = [];  
    
    
    protected function clear()
    {
        $this->acc = $this->lastChunk;
        $this->rawNodes = [];
        
        return $this;
    }
    
    
    /**
     * Resets the detector
     * 
     * @return      Detector        This instance
     */
    public function reset()
    {
        $this->clear();
        $this->acc = $this->lastChunk = '';
        return $this;
    }
    
    
    /**
     * Appends new chunk
     * 
     * @return      Detector        This instance
     */
    protected function append($chunk)
    {
        $this->lastChunk = $chunk;
        $this->acc = sprintf('%s%s', $this->acc, $chunk);
        
        return $this;
    }
    
    
    protected function validateSet()
    {
        $matches = [];
        if (preg_match_all($this->getPattern(), $this->acc, $matches)) {
            $this->rawNodes = $matches[0];
            return true;
        }
        
        return false;
    }
    
    
    protected function getPattern()
    {
        return strtr(self::REGEX_PATTERN, [
            ':node:' => $this->nodeName
        ]);
    }


    /**
     * Sets node that the detector will look for in the chunks
     * 
     * @param       string          $nodeName
     * 
     * @return      Detector        This instance
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
        return $this;
    }
    
    
    /**
     * Returns bool if preset node has been detected in the stream of chunks
     * 
     * @param       string          $chunk
     * @return      bool
     */
    public function hasNodes($chunk)
    {
        return $this
                    ->append($chunk)
                    ->validateSet();
    }
    
    
    /**
     * Returns an array of node strings that represents full XML node
     * 
     * @return      array
     */
    public function getNodesText()
    {
        return !count($this->rawNodes) ? $this->throwException() : $this->getRawNodes();
    }
    
    
    protected function getRawNodes()
    {
        $rawNodes = $this->rawNodes;
        $this->clear();

        return $rawNodes;
    }
    
    
    protected function throwException()
    {
        throw new RuntimeException('The node text is not set!');
    }
}