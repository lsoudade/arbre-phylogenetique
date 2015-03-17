<?php

namespace Project\Lib;

class Sitemap
{
    const URL_LIMIT = 50000,
          WINDOW    = 1000,
          HOST      = 'http://www.qesto.fr';
    
    protected $app,
              $limit;
    
    public function __construct($app) 
    {
        $this->app   = $app;
        $this->limit = min($this->app['manager.question']->count(), self::URL_LIMIT);
    }
    
    public function generate() 
    {
        // Initialization
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
               '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        $xml .= $this->addRoutes(array(
            'signin',
            'signup',
            'aboutUs',
            'contact',
            'lost_password',
            'question_latest',
            'question_popular'
        ));
        
        $iterations = ceil($this->limit/self::WINDOW);
        
        for ( $page = 1 ; $page <= $iterations ; $page++ ) {
            $questions = $this->app['manager.question']->getRepository()->findAll(
                array(),
                array('id', 'slug'),
                array('id' => 'ASC'),
                self::WINDOW, // max rows
                (($page-1)*self::WINDOW) // offset
            );
            
            foreach ( $questions as $question ) {
                $xml .= sprintf(
                    '<url><loc>%s</loc></url>' . "\n", 
                    self::HOST . $this->app['url_generator']->generate('question_show', array( 'id' => $question['id'], 'slug' => $question['slug'] ))
                );
            }
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
    
    protected function addRoutes($routes) 
    {
        $xml = '';
        
        foreach ( $routes as $route ) {
            $xml .= sprintf(
                '<url><loc>%s</loc></url>' . "\n",
                self::HOST . $this->app['url_generator']->generate($route, array())
            );
        }
        
        return $xml;
    }
}