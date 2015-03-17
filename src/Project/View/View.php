<?php

namespace Project\View;

class View
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function render($template, array $data)
    {
        return $this->app['twig']->render($template . '.twig', $data);
    }
}