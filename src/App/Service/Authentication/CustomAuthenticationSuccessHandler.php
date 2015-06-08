<?php

namespace App\Service\Authentication;

use Silex\Application;

use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Custom Authentication Success Handler
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class CustomAuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler {

    protected $app = null;

    /**
     * Authentication Success Construct
     * 
     * @param HttpUtils $httpUtils
     * @param array $options
     * @param Application $app
     */
    public function __construct(HttpUtils $httpUtils, array $options, Application $app)
    {
        parent::__construct($httpUtils, $options);

        $this->app = $app;
    }

    /**
     * Authentication Success
     * 
     * @param Request $request
     * @param TokenInterface $token
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Authorized access, redirects to the admin
        $result = array(
            'status' => 'success',
            'message' => 'Authorized access.',
            'redirect' => $this->app['url_generator']->generate('admin')
        );

        return $this->app->json($result);
    }

}