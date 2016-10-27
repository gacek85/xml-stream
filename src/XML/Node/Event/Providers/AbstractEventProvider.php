<?php
namespace Gacek85\XML\Node\Event\Providers;

use Gacek85\XML\Node\Event\ProviderInterface;

/**
 *  Abstraction for event providers 
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
abstract class AbstractEventProvider implements ProviderInterface 
{
    protected function validate(array $params, $key)
    {
        if (!array_key_exists($key, $params)) {
            throw new \InvalidArgumentException(sprintf(
                'Parameter %s does not exist!',
                $key
            ));
        }
        
        return $params[$key];
    }
}