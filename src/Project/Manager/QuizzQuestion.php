<?php

namespace Project\Manager;

class QuizzQuestion extends Manager
{
    protected $app,
              $repository;
    
    public function __construct($app) 
    {
        $this->app            = $app;
        $this->repository     = new \Project\Repository\QuizzQuestion($app['db']);
    }
    
    public function create(array $data) 
    {
        return $this->repository->insert($data);
    }
    
    public function findByQuizzId($quizz_id) 
    {
        $questionsTmp = $this->repository->findByQuizzId($quizz_id);
        $questions    = array();
        
        foreach ( $questionsTmp as $question ) {
            $question['answers'] = $this->app['manager.quizz_answer']->findByQuizzQuestionId($question['id']);
            $questions[] = $question;
        }
        
        return $questions;
    }
}