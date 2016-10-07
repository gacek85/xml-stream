<?php
namespace Gacek85\XML\Node\Event;

use Gacek85\XML\Node\Event\Feature\ProviderInterface as FeatureProviderInterface;
use Gacek85\XML\Node\Event\ProviderInterface;
use InvalidArgumentException;

/**
 *  Provides events for XML nodes. Default implementation of
 *  EventProviderInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class Provider implements ProviderInterface
{
    /**
     *
     * @var FeatureProviderInterface[]
     */
    protected $featureProviders = [];
    
    
    /**
     * Adds new feature provider
     * 
     * @param       FeatureProviderInterface        $featureProvider
     * 
     * @return      EventProvider
     * 
     * @throws      InvalidArgumentException        If provider for given feature
     *                                              is already set
     */
    public function addFeatureProvider(FeatureProviderInterface $featureProvider)
    {
        if (array_key_exists($featureProvider->getFeature(), $this->featureProviders)) {
            throw new InvalidArgumentException(sprintf(
                'Feature provider for `%s` already exists.',
                $featureProvider->getFeature()
            ));
        }
        $this->featureProviders[$featureProvider->getFeature()] = $featureProvider;
        
        return $this;
    }

    

    /**
     * Creates the event for given node
     * 
     * @param       int                 $counter
     * 
     * @param       string              $nodeName
     * 
     * @param       string              $node
     * 
     * @return      Event
     */
    public function createEvent($counter, $nodeName, $node)
    {
        return $this->populate(new Event($counter, $nodeName, $node));
    }
    
    
    protected function populate(Event $nodeEvent)
    {
        array_map(function(FeatureProviderInterface $featureProvider) use ($nodeEvent) {
            $nodeEvent->addFeature($featureProvider->getFeature(), $featureProvider->provide($nodeEvent));
        }, $this->featureProviders);
        
        return $nodeEvent;
    }
}