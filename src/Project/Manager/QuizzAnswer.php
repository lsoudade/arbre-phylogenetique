<?php

namespace Project\Manager;

class QuizzAnswer extends Manager
{
    protected $app,
              $repository;
    
    public function __construct($app) 
    {
        $this->app            = $app;
        $this->repository     = new \Project\Repository\QuizzAnswer($app['db']);
    }
    
    public function create(array $data) 
    {
        return $this->repository->insert($data);
    }
    
    public function findByQuizzQuestionId($quizz_question_id) 
    {
        return $this->repository->findByQuizzQuestionId($quizz_question_id);
    }
}