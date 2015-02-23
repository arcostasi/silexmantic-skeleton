<?php

/**
 * Define Routes Controller
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */

// Index Routes
$app->mount('/', new App\Controller\IndexController());

// User Routes
$app->mount('/user', new App\Controller\UserController());