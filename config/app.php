<?php


/**
 * Application and Providers Configuration
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */

use Silex\Application;

$app->register(new Silex\Provider\HttpCacheServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Template Engine Definition
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.options' => array(
        'cache' => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
        'strict_variables' => true
    ),
    'twig.path' => array(PATH_VIEWS),
    'twig.options' => array('debug' => $app['debug'])
));

// Database Definition
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__.'/app.db',
    ),
));

// Security Definition
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'index' => array(
            'pattern' => '^/$',
            'anonymous' => true
        ),
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true
        ),
        'admin' => array(
            'pattern' => '^.*$',
            'anonymous' => false,
            'form' => array(
                'login_path' => '/user/login',
                'check_path' => '/user/auth',
                'username_parameter' => 'username',
                'password_parameter' => 'password',
            ),
            'logout' => array(
                'logout_path' => '/user/logout',
            ),
            'users' => $app->share(function() use ($app) {

                return new App\Provider\UserProvider($app['db']);
            }),
        ),
    ),
));

$app['security.authentication.success_handler.admin'] = $app->share(function() use ($app) {
    // Success Authentication
    return new App\Service\Authentication\CustomAuthenticationSuccessHandler($app['security.http_utils'], array(), $app);
});

// Log Definition
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => PATH_LOG . '/app.log',
    'monolog.name'  => 'app',
    'monolog.level' => 300 // = Logger::WARNING
));

// Errors Exception
$app->error(function(\Exception $e, $code) use($app) {

    $file = pathinfo($e->getFile());

    return $app->json([
        'success' => false,
        'message' => 'Error',
        'error' => $e->getMessage(),
        'serverror' => $code,
        'source' => $file['filename'],
        'line' => $e->getLine()
    ], $code);
});