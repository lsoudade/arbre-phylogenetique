<?php

namespace Project\Bin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ComputeUsersExperience extends Bin
{
    protected function configure()
    {
        $this->setName('users:compute-experience');
    }
    
    protected function process(InputInterface $input)
    {
        $this->app['experience.computer']->compute();
    }
}