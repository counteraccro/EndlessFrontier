<?php 

namespace App\Service;

use Symfony\Component\Finder\Finder;
use Symfony\Component\DomCrawler\Crawler;

class GuildInvasion {
    
    CONST XML_PATH = DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR. 'public' . DIRECTORY_SEPARATOR . 'xml';
    
    public function generateGrid()
    {
        $this->openXMLFile();
    }
    
    private function openXMLFile()
    {
        $path = dirname(__DIR__). self::XML_PATH;
        
        $finder = new Finder();
        $finder->files()->in($path);
        
        if($finder->count() > 1)
        {
            throw new \Exception("Several files have been detected, only one file must be present");
        }
        
        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
        }
        
        $xml = simplexml_load_file($absoluteFilePath);
        
        foreach($xml as $element)
        {
            $this->debug($element);
           
        }
        
    }
    
    private function debug($data)
    {
        echo '<pre>';
        echo print_r($data);
        echo '</pre>';
    }
}