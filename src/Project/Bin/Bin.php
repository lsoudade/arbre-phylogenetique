<?php

namespace Project\Bin;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Bin extends Command
{
    protected $app,
              $output;
    
    public function __construct($app)
    {
        parent::__construct();
        
        $this->app = $app;
    }
    
    protected function execute(InputInterface $input, OutPutInterface $output)
    {
        $this->output = $output;
        
        $this->comment('Start : ' . date('Y-m-d H:i:s'));
        
        $this->printArgs($input);
        
        $this->process($input, $output);
        
        $this->comment('End : ' . date('Y-m-d H:i:s'));
    }
    
    protected function info($msg, $newLine = true) 
    {
        $this->out('<info>' . $msg . '</info>', $newLine);
    }
    
    protected function comment($msg, $newLine = true) 
    {
        $this->out('<comment>' . $msg . '</comment>', $newLine);
    }
    
    protected function question($msg, $newLine = true) 
    {
        $this->out('<question>' . $msg . '</question>', $newLine);
    }
    
    protected function error($msg, $newLine = true) 
    {
        $this->out('<error>' . $msg . '</error>', $newLine);
    }
    
    protected function out($msg, $newLine = true)
    {
        if ( $newLine ) {
            $this->output->writeln($msg);
        } else {
            $this->output->write($msg);
        }
    }
    
    /**
     * Print arguments & options values on console
     * 
     * @param type $input
     */
    protected function printArgs($input)
    {
        $arguments = array_slice($input->getArguments(), 1);
        // Filter empty values
        $arguments = array_filter($arguments, 'strlen');
        if ( count($arguments) > 0 ) {
            $this->out('<comment>----------------------</comment>');
            $this->out('<comment>Arguments : </comment>');
            foreach ( $arguments as $name => $value ) {
                if ( !empty($value) ) {
                    $this->out('    <comment>' . $name . ' : ' . $value . '</comment>');
                }
            }
        }
        
        // Filter empty values
        $options = array_filter($input->getOptions(), 'strlen');
        if ( count($options) > 0 ) {
            $this->out('<comment>----------------------</comment>');
            $this->out('<comment>Options : </comment>');
            foreach ( $options as $name => $value ) {
                if ( !empty($value) ) {
                    $this->out('    <comment>' . $name . ' : ' . $value . '</comment>');
                }
            }
        }
    }
}