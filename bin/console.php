<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__ . '/../www/bootstrap.php';

$console = new \Symfony\Component\Console\Application();

// Add bin classes here
$console->add(new \Project\Bin\ComputeUsersExperience($app));
$console->add(new \Project\Bin\SitemapGenerator($app));
$console->add(new \Project\Bin\SitemapPublisher($app));

$console->run();