<?php

namespace App\Service\Authentication;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

/**
 * Custom Authentication Failure Handler
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class CustomAuthenticationFailureHandler implements AuthenticationFailureHandlerInterface {

    /**
     * Authentication Failure Construct
     * 
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Authentication Failure
     * 
     * @param Request $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $post = $request->request->all();

        $result = array(
            'status' => 'error',
            'message' => null,
            'code' => 401
        );

        // Validates the login parameters
        if (!$post['username']) {
            $result['message'] = 'Invalid User.';
        } else if (!$post['password']) {
            $result['message'] = 'Invalid password.';
        } else if ($exception->getMessage() == 'Bad credentials.') {
            $result['message'] = 'Unauthorized access.';
            return $this->app->json($result);
        } else {
            $result['message'] = $exception->getMessage();
        }

        return $this->app->json($result, 401);
    }
}
