<?php

/**
 * Declares controllers as shared services
 */
$app['controller.frontend'] = $app->share(function () use ($app) {
    return new \Project\Controller\Frontend($app);
});

$app['controller.authentication'] = $app->share(function () use ($app) {
    return new \Project\Controller\Authentication($app);
});

$app['controller.phylogenetic'] = $app->share(function () use ($app) {
    return new \Project\Controller\Phylogenetic($app);
});

$app['controller.registration'] = $app->share(function () use ($app) {
    return new \Project\Controller\Registration($app);
});

$app['controller.user'] = $app->share(function () use ($app) {
    return new \Project\Controller\User($app);
});

/**
 * Declares managers as shared services
 */
$app['manager.contact'] = $app->share(function ($app) {
    return new \Project\Manager\Contact($app);
});

$app['manager.passwordToken'] = $app->share(function ($app) {
    return new \Project\Manager\PasswordToken($app);
});

$app['manager.user'] = $app->share(function ($app) {
    return new \Project\Manager\User($app);
});


/**
 * Declares forms as services
 */
$app['form.contact'] = function ($app) {
    return new \Project\Form\ContactForm($app);
};

$app['form.email'] = function ($app) {
    return new \Project\Form\EmailForm($app);
};

$app['form.lostPassword'] = function ($app) {
    return new \Project\Form\LostPasswordForm($app);
};

$app['form.newPassword'] = function ($app) {
    return new \Project\Form\NewPasswordForm($app);
};

$app['form.signup'] = function ($app) {
    return new \Project\Form\SignupForm($app);
};

$app['form.username'] = function ($app) {
    return new \Project\Form\UsernameForm($app);
};



/**
 * Other services
 */
$app['constant.parser'] = $app->share(function () {
    return new \Project\Lib\ConstantParser();
});

$app['flashbag'] = $app->share(function ($app) {
    return new \Project\Session\FlashBag($app);
});

$app['password'] = $app->share(function ($app) {
    return new \Project\Security\Password($app);
});

$app['lib.phylogenetic'] = $app->share(function ($app) {
    return new \Project\Lib\Phylogenetic($app);
});

$app['mailer'] = $app->share(function ($app) {
    return new \Project\Lib\Mailer($app);
});

$app['slugify'] = $app->share(function () {
    return new \Cocur\Slugify\Slugify();
});

$app['sitemap'] = $app->share(function ($app) {
    return new \Project\Lib\Sitemap($app);
});

$app['view'] = $app->share(function ($app) {
    return new \Project\View\View($app);
});