<?php

// Define Paths
define('PATH_ROOT', dirname(__DIR__));
define('PATH_CACHE', PATH_ROOT . '/data');
define('PATH_LOG', PATH_CACHE . '/log');
define('PATH_SRC', PATH_ROOT . '/src');
define('PATH_CONFIG', PATH_ROOT . '/config');
define('PATH_PUBLIC', PATH_ROOT . '/public');
define('PATH_VENDOR', PATH_ROOT . '/vendor');
define('PATH_VIEWS', PATH_ROOT . '/views');

// Autoload
require PATH_VENDOR . '/autoload.php';

// App Init
$app = new Silex\Application();

require PATH_CONFIG . '/config.php';
require PATH_CONFIG . '/app.php';
require PATH_CONFIG . '/routes.php';

// Development
$app->run();