[![Build Status](https://travis-ci.org/gacek85/xml-stream.svg?branch=develop)](https://travis-ci.org/gacek85/xml-stream)

# XML Stream

- Simple library for dealing with large XML lists.

- Parses **XML** file chunk by chunk not loading the whole file to the memory and dispatches events informing about found node of given type.

- The main component is the `Gacek85\XML\Stream` class which wraps all the dependent elemets.

``` php
<?php

use Gacek85\XML\Chunk\Provider as ChunkProvider;
use Gacek85\XML\Node\Detector as NodeDetector;
use Gacek85\XML\Node\Event\Event as NodeEvent;
use Gacek85\XML\Node\Event\EventInterface;
use Gacek85\XML\Node\Event\Feature\DOMElementProvider;
use Gacek85\XML\Node\Event\Provider as EventProvider;
use Gacek85\XML\Stream;
use Symfony\Component\EventDispatcher\EventDispatcher;

$eventProvider = (new EventProvider())
                    ->addFeatureProvider(new DOMElementProvider());

$stream = new Stream(
            new EventDispatcher(),
            new ChunkProvider('/path/to/file.xml', 1024),	// 2nd param is chunk length
            new NodeDetector(),
            $eventProvider
);

$stream
		->getDispatcher()
        ->addListener(EventInterface::NAME, function (NodeEvent $ev) {
			// Do your stuff here
		});

$stream->read('listNodeName');
```