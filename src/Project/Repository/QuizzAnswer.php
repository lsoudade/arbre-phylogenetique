<?php

namespace Project\Repository;

class QuizzAnswer extends Repository
{
    public function __construct($dbConnector)
    {
        parent::__construct($dbConnector,'quizz_answer', 'id');
    }
    
    public function findByQuizzQuestionId($quizz_question_id)
    {
        $qb = $this->db->createQueryBuilder()
            ->select('qa.*' )
            ->from($this->tableName, 'qa')
            ->where('qa.quizz_question_id = :quizz_question_id')
            ->setParameter('quizz_question_id', $quizz_question_id);
        
        return $qb->execute()
            ->fetchAll();
    }
}