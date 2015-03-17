<?php

namespace Project\Bin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SitemapGenerator extends Bin
{
    protected function configure()
    {
        $this->setName('sitemap:generate');
        $this->path = __DIR__ . '/../../../www/sitemap.xml';
    }
    
    protected function process(InputInterface $input)
    {
        $xml = $this->app['sitemap']->generate();
        
        file_put_contents($this->path, $xml);
        
        
        // Is auto submit a good idea or spam ?
        
        // Send sitemap to google
//        file_get_contents('http://www.google.com/webmasters/tools/ping?sitemap=http://www.qesto.fr/sitemap.xml');
        
        // Send sitemap to bing
//        file_get_contents('http://www.bing.com/webmaster/ping.aspx?siteMap=http://www.qesto.fr/sitemap.xml');
    }
}