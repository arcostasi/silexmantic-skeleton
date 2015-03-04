<?php

namespace App\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Index Controller Provider
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class IndexController implements ControllerProviderInterface {

    /**
     * Index Connect
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $indexController = $app['controllers_factory'];
        $indexController->get('/', array($this, 'indexAction'))->bind('index');

        return $indexController;
    }

    /**
     * Index Action
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Application $app)
    {
        return $app['twig']->render('index.twig');
    }

}