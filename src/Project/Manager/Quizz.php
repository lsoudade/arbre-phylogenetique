<?php

namespace Project\Manager;

class Quizz extends Manager
{
    protected $app,
              $repository;
    
    public function __construct($app) 
    {
        $this->app            = $app;
        $this->repository     = new \Project\Repository\Quizz($app['db']);
    }
    
    public function create(array $data) 
    {
        $data['slug'] = $this->app['slugify']->slugify($data['title']);
        
        return $this->repository->insert($data);
    }
    
    public function findAll()
    {
        return $this->repository->findAll();
    }
    
    public function find($id) 
    {
        return $this->repository->findByPk($id);
    }
    
    public function findFullStack($id) 
    {
        $quizz = $this->find($id);
        $quizz['questions'] = $this->app['manager.quizz_question']->findByQuizzId($id) ;
        
        return $quizz;
    }
}