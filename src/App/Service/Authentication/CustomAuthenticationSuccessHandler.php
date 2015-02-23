<?php

namespace App\Service\Authentication;

use Silex\Application;

use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Classe utilizada para customizar a autenticação com sucesso
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class CustomAuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler {

    protected $app = null;

    public function __construct(HttpUtils $httpUtils, array $options, Application $app) 
    {
        parent::__construct($httpUtils, $options);

        $this->app = $app;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) 
    {
        $this->app['security']->setToken($token);

        return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
    }

}