<?php

/*
 * Matrice routing
 */
$app->get('/', 'controller.phylogenetic:matrice')->bind('homepage');
$app->post('/save-matrice-case/{taxa}/{character}', 'controller.phylogenetic:saveMatriceCase')->bind('save_matrice_case');
$app->post('/save-matrice-taxa-name/{number}', 'controller.phylogenetic:saveMatriceTaxaName')->bind('save_matrice_taxa_name');
$app->post('/matrice-add-character', 'controller.phylogenetic:matriceAddCharacter')->bind('matrice_add_character');
$app->post('/matrice-add-taxa', 'controller.phylogenetic:matriceAddTaxa')->bind('matrice_add_taxa');
$app->post('/matrice-reset', 'controller.phylogenetic:matriceReset')->bind('matrice_reset');

//$app->match('/inscription', 'controller.registration:signup')->bind('signup')->method('GET|POST');
$app->get('/connexion', 'controller.authentication:signin')->bind('signin');

$app->get('/mentions-legales', 'controller.frontend:aboutUs')->bind('aboutUs');
$app->match('/contact', 'controller.frontend:contact')->bind('contact')->method('GET|POST');

/*
 * Lost password
 */
$app->match('/mot-de-passe-perdu', 'controller.authentication:lostPassword')->bind('lost_password')->method('GET|POST');
$app->match('/mot-de-passe-perdu/reinitialiser/{token}', 'controller.authentication:lostPasswordReinitialize')->bind('lost_password_reinitialize')->method('GET|POST');




/*
 * User routing
 */
//$app->get('/mon-compte', 'controller.user:edit')->bind('user_edit');
//$app->match('/mon-compte/email', 'controller.user:editEmail')->bind('user_edit_email')->method('GET|POST');
//$app->match('/mon-compte/username', 'controller.user:editUsername')->bind('user_edit_username')->method('GET|POST');
//$app->match('/mon-compte/password', 'controller.user:editPassword')->bind('user_edit_password')->method('GET|POST');

/*
 * Custom routing
 */
//$app->match('/route/sample', 'controller.frontend:action')->bind('default_action')->method('GET|POST');
//$app->get('/route/sample/{page}', 'controller.frontend:action')->value('page', 1)->bind('default_action');