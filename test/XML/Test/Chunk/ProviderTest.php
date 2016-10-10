<?php
namespace Gacek85\XML\Test\Chunk;

use Gacek85\XML\Chunk\Provider;
use PHPUnit_Framework_TestCase;
use Faker\Factory as FakerFactory;

/**
 *  Test case for Reader
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class ProviderTest extends PHPUnit_Framework_TestCase 
{
    const TEST_LENGTH = 1000;
    
    protected function tearDown()
    {
        if (file_exists($fp = $this->getFilePath())) {
            unlink($fp);
        }
    }
    
    protected function createFile ()
    {
        if (!file_exists($fp = $this->getFilePath())) {
            $faker = FakerFactory::create();
            for ($i = 0; $i < self::TEST_LENGTH; $i++) {
                file_put_contents($fp, $faker->sentence(6), FILE_APPEND);
            }
        }
        
        return $fp;
    }
    
    protected function getFilePath ()
    {
        return sprintf('%s/../../../Resources/test_file.txt', __DIR__);
    }
    
    public function testGetChunk()
    {
        $that = $this;
        array_map(function($length) use ($that) {
            $that->doTestGetChunk($length);
        }, [1, 10, 100, 1000, Provider::DEFAULT_CHUNK_LENGTH]);
    }
    
    public function doTestGetChunk($length = Provider::DEFAULT_CHUNK_LENGTH)
    {
        $reader = new Provider($fp = $this->createFile($length));
        $contents = file_get_contents($fp);
        $buffer = '';
        while($reader->hasChunk()) {
            $buffer .= $reader->getChunk(); 
        }
        
        $this->assertFalse($reader->hasChunk());
        $this->assertTrue($reader->isEof());
        $this->assertEquals($contents, $buffer);
        
        return $reader;
    }
    
    
    /**
     * @expectedException \LogicException
     */
    public function testNonExisting()
    {
        $reader = new Provider('/non/existing/path');
        $reader->hasChunk();
    }
    
    
    /**
     * @expectedException \Gacek85\XML\Exception\EofException
     */
    public function testEof()
    {
        $this->doTestGetChunk()->getChunk();
    }
}