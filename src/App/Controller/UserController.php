<?php

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User Controller Provider
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class UserController implements ControllerProviderInterface {

    /**
     * User Connect
     *
     * @param Silex\Application $app
     * @return $app['controllers_factory']
     */
    public function connect(Application $app) 
    {
        $userController = $app['controllers_factory'];
        $userController->get('/login', array($this, 'loginAction'))->bind('login');

        return $userController;
    }

    public function loginAction(Application $app) 
    {
        return $app->json(['login']);
    }

}