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
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $userController = $app['controllers_factory'];
        $userController->get('/login', array($this, 'loginAction'))->bind('login');

        return $userController;
    }

    /**
     * Login Action
     * 
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function loginAction(Application $app)
    {
        return $app['twig']->render('user/login.twig', array());
    }

}