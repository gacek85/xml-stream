<?php
namespace Gacek85\XML\Node\Event;

use InvalidArgumentException;

/**
 *  Event providers aggregator
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class Aggregator implements ProviderAwareInterface 
{

    const NAME = "xml_stream.%s";

    /**
     * Returns event name
     * 
     * @return      string
     */
    public function getName()
    {
        return sprintf(
            self::NAME, 
            $this->getCurrent()->getName()
        );
    }
    
    /**
     *
     * @var ProviderInterface[]
     */
    protected $providers = [];
    
    
    /**
     *
     * @var ProviderInterface
     */
    protected $provider = null;
    
    
    /**
     * Sets given provider for usage
     * 
     * @param       string                      $name
     * 
     * @return      Aggregator                  This instance
     * 
     * @throws      InvalidArgumentException    If provider for given name not found
     */
    public function useProvider($name)
    {
        $this->provider = $this->getProvider($name);
        return $this;
    }
    
    
    protected function getCurrent()
    {
        if ($this->provider === null) {
            throw new \RuntimeException(sprintf(
                'Provider not set! Use %s::%s to set the provider.', 
                Aggregator::class,
                'useProvider'
            ));
        }
        
        return $this->provider;
    }


    /**
     * Returns provider for given name
     * 
     * @param       string                      $name
     * 
     * @return      ProviderInterface
     * 
     * @throws      InvalidArgumentException    If provider for given name not found
     */
    public function getProvider($name)
    {
        if (!array_key_exists($name, $this->providers)) {
            throw new InvalidArgumentException(sprintf(
                'Provider for name %s does not exist!',
                $name
            ));
        }
        
        return $this->providers[$name];
    }
    
    
    /**
     * 
     * @param       ProviderInterface       $provider
     * 
     * @return      Aggregator              This instance            
     */
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[$provider->getName()] = $provider;
        return $this;
    }
    
    
    /**
     * Creates the event for given node
     * 
     * @param       string              $name
     * 
     * @param       array               $params
     * 
     * @return      EventInterface
     */
    public function createEvent(array $params)
    {
        return $this->getCurrent()->createEvent($params);
    }
}