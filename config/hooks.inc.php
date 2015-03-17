<?php

/**
 * 
 */
$app->before(function ($request) use ($app) {
    $request->getSession()->start();
});

$app->after(function (\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\HttpFoundation\Response $response) use ($app) {
    
});