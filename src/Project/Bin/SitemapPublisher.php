<?php

namespace Project\Bin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SitemapPublisher extends Bin
{
    protected function configure()
    {
        $this->setName('sitemap:publish');
        $this->url = 'http://www.qesto.fr/sitemap.xml';
    }
    
    protected function process(InputInterface $input)
    {
        $google = 'http://www.google.com/webmasters/tools/ping?sitemap=';
        $bing   = 'http://www.bing.com/webmaster/ping.aspx?siteMap=';
        
        file_get_contents($bing . $this->url);
        file_get_contents($google . $this->url);
    }
}