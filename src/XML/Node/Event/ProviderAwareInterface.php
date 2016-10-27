<?php
namespace Gacek85\XML\Node\Event;


/**
 *  Interface that provides ability to resolve provider
 *  for given name
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
interface ProviderAwareInterface extends ProviderInterface 
{
    const NAME_START = 'start';
    
    const NAME_END = 'end';
    
    const NAME_NODE = 'node';
        
    
    /**
     * Sets given provider for usage
     * 
     * @param       string                      $name
     * 
     * @return      ProviderAwareInterface      This instance
     */
    public function useProvider($name);
}