<?php
namespace Gacek85\XML\Node\Event\Feature;

use DOMDocument;
use DOMElement;
use Gacek85\XML\Node\Event\Event;

/**
 *  Provides DOMElement object for given node
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class DOMElementProvider implements ProviderInterface 
{
    
    const FEATURE = 'dom_element';


    
    /**
     * Provides the feature name parser is able to extract from
     * the node 
     * 
     * @return      string
     */
    public function getFeature()
    {
        return self::FEATURE;
    }
    
    
    /**
     * Returns node feature
     * 
     * @param       Event       $nodeEvent
     * @return      DOMElement
     */
    public function provide(Event $nodeEvent)
    {
        return $this->createDomElement($nodeEvent);
    }
    
    protected function createDomElement(Event $nodeEvent)
    {
        $dom = new DOMDocument();
        $previousValue = libxml_use_internal_errors(true);
        $dom->loadXML($this->getFullXML($nodeEvent->getRawNode()));
        libxml_clear_errors();
        libxml_use_internal_errors($previousValue);
        
        return $dom->getElementsByTagName($nodeEvent->getNodeName())->item(0);
    }
        
    protected function getFullXML($node)
    {
        return trim(sprintf(<<<EOD
            <?xml version="1.0" encoding="UTF-8" ?>
            <root>
                %s
            </root>
EOD
        , $node));
    }
}