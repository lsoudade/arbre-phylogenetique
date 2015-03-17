<?php

namespace Project\Repository;

class Quizz extends Repository
{
    public function __construct($dbConnector)
    {
        parent::__construct($dbConnector,'quizz', 'id');
    }
}