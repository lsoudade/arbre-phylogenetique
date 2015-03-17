<?php

namespace Project\Manager;

class Contact extends Manager
{
    protected $app,
              $repository;
    
    public function __construct($app) 
    {
        $this->app            = $app;
        $this->repository     = new \Project\Repository\Contact($app['db']);
    }
    
    public function create(array $data) 
    {
        // Dates
        $now = date('Y-m-d H:i:s');
        $data['created'] = $now;
        $data['updated'] = $now;
        
        // Create question in db
        return $this->repository->insert($data);
    }
}