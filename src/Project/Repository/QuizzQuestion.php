<?php

namespace Project\Repository;

class QuizzQuestion extends Repository
{
    public function __construct($dbConnector)
    {
        parent::__construct($dbConnector,'quizz_question', 'id');
    }
    
    public function findByQuizzId($quizz_id)
    {
        $qb = $this->db->createQueryBuilder()
            ->select('qq.*' )
            ->from($this->tableName, 'qq')
            ->where('qq.quizz_id = :quizz_id')
            ->setParameter('quizz_id', $quizz_id)
            ->addOrderBy('qq.priority', 'ASC');
        
        return $qb->execute()
            ->fetchAll();
    }
}