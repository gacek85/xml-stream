<?php
namespace Gacek85\XML\Test\Node;

use Gacek85\XML\Node\Detector;
use PHPUnit_Framework_TestCase;
use RuntimeException;

/**
 *  Test case for NodeDetector
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class DetectorTest extends PHPUnit_Framework_TestCase 
{
    const CONTENT_PATH_PATTERN = '%s/../../../Resources/xml/%s';
    
    
    /**
     *
     * @var Detector
     */
    protected $nodeDetector = null;
    
    
    protected function setUp()
    {
        $this->nodeDetector = new Detector();
    }
    
    
    protected function getContentPath ($file)
    {
        return sprintf(
            self::CONTENT_PATH_PATTERN, 
            __DIR__, 
            $file
        );
    }
    
    
    protected function getTestContent ()
    {
        return [
            [
                'files' => [
                    $this->getContentPath('full_node.txt')
                ],
                'node' => 'item',
                'count' => 1
            ],
            [
                'files' => [
                    $this->getContentPath('three_nodes.txt')
                ],
                'node' => 'item',
                'count' => 3
            ],
            [
                'files' => [
                    $this->getContentPath('no_node.txt')
                ],
                'node' => 'item',
                'count' => 0
            ]
        ];
    }
    
    public function testNodeDetector ()
    {
        $that = $this;
        array_map(function (array $item) use ($that) {
            if (count($item['files'] === 1)) {
                $that->doTestSingle($item);
            }
        }, $this->getTestContent());
    }
    
    public function doTestSingle(array $item)
    {
        $this
            ->nodeDetector
            ->reset()
            ->setNodeName($item['node'])
        ;
        
        if ($item['count']) {
            $this->assertTrue($this->nodeDetector->hasNodes(file_get_contents($item['files'][0])));
            $this->assertCount($item['count'], $this->nodeDetector->getNodesText());
        } else {
            $this->assertFalse($this->nodeDetector->hasNodes(file_get_contents($item['files'][0])));
            $hasException = false;
            try {
                $this->nodeDetector->getNodesText();
            } catch (RuntimeException $ex) {
                $hasException = true;
            }
            $this->assertTrue($hasException);
        }
    }
}