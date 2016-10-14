<?php
namespace Gacek85\XML\Test\Tools;

use Faker\Generator;

/**
 *  Generates XML
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 *  @copyrights Maciej Garycki 2016
 */
class XmlGenerator 
{
    
    protected $nodesCount = null;
    
    
    protected $nodeName = null;
    
    
    /**
     *
     * @var Generator
     */
    protected $faker = null;
    
    
    public function __construct($nodesCount, $nodeName, Generator $faker)
    {
        $this->nodesCount = $nodesCount;
        $this->nodeName = $nodeName;
        $this->faker = $faker;
    }
    
    
    /**
     * Generates the XML in given file
     */
    public function generate($path)
    {
        $root = $this->getUniqueWord([$this->nodeName]);
        $this->addFileHeader($path, $root);
        
        $this->addFileNodes($path);
        
        // Closing the root tag
        $this->addToFile($path, sprintf('</%s>', $root));
        
        return $path;
    }
    
    
    protected function addFileNodes($path)
    {
        array_map(function() use ($path){
            $this->addToFile($path, $this->generateNode($this->nodeName));
        }, array_fill(0, $this->nodesCount, null));
    }



    protected function addFileHeader($path, $rootNode)
    {
        $this->addToFile($path, sprintf(
            '<?xml version="1.0" encoding="UTF-8" ?><%s>',
            $rootNode
        ));
    }
    
    
    protected function addToFile($path, $contents)
    {
        file_put_contents($path, $contents, FILE_APPEND);
    }
    
    
    protected function generateNode($nodeName)
    {
        return $this->doGenerate($nodeName, 1, 4);
    }
    
    protected function doGenerate(
        $nodeName, 
        $minDepth, 
        $maxDepth, 
        array $notNodes = []
    ){
        $attrs = $this->getAttributes(mt_rand(0, 3));
        $notNodesMerged = array_merge($notNodes, [$nodeName]);
        return mt_rand($minDepth, $maxDepth) ? sprintf(
            "<%s%s>%s</%s>\n\r",
            $nodeName,
            $attrs,
            $this->doGenerate($this->getUniqueWord($notNodesMerged), 0, --$maxDepth, $notNodesMerged),
            $nodeName
        ) : sprintf("<%s%s />", $nodeName, $attrs);
    }
    
    
    protected function getAttributes($num)
    {
        return $num ? sprintf(' %s', $this->doGetAttributes($num)) : '';
    }
    
    
    protected function doGetAttributes ($num)
    {
        return implode(' ', array_map(function ($word){
            return sprintf(
                    '%s="%s"',
                    $word,
                    $this->faker->words(mt_rand(0, 5), true)
            );
        }, $this->getUniqueWords($num)));
    }
    
    
    public function getUniqueWords($num)
    {
        $words = [];
        while(count($words) < $num) {
            $words[] = $this->getUniqueWord($words);
        }
        
        return $words;
    }
    
    public function getUniqueWord(array $notWords = [])
    {
        do {
            $word = $this->faker->word;
        } while (!mb_strlen($word) || in_array($word, $notWords, true));
        
        return $word;
    }
}