<?php
namespace Gacek85\XML\Node\Event\Providers;

use Gacek85\XML\Node\Event\Feature\ProviderInterface as FeatureProviderInterface;
use Gacek85\XML\Node\Event\ProviderInterface;
use InvalidArgumentException;
use Gacek85\XML\Node\Event\NodeEvent as Event;

/**
 *  Provides events for XML nodes. Default implementation of
 *  EventProviderInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class NodeEventProvider extends AbstractEventProvider implements ProviderInterface
{

    const NAME = "node";

    /**
     *
     * @var FeatureProviderInterface[]
     */
    protected $featureProviders = [];
    

    /**
     * Returns event name
     * 
     * @return      string
     */
    public function getName()
    {
        return self::NAME;
    }
    
    
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
     * @param       array               $params
     * 
     * @return      NodeEvent
     */
    public function createEvent(array $params)
    {
        return $this->populate(new Event(
            $this->validate($params, 'counter'), 
            $this->validate($params, 'nodeName'), 
            $this->validate($params, 'node')
        ));
    }
    
    
    protected function populate(Event $nodeEvent)
    {
        array_map(function(FeatureProviderInterface $featureProvider) use ($nodeEvent) {
            $nodeEvent->addFeature($featureProvider->getFeature(), $featureProvider->provide($nodeEvent));
        }, $this->featureProviders);
        
        return $nodeEvent;
    }
}