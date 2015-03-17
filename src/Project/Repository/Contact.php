<?php

namespace Project\Repository;

class Contact extends Repository
{
    public function __construct($dbConnector)
    {
        parent::__construct($dbConnector,'contact', 'id');
    }
}