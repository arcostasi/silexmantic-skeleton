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
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Authentication Failure
     * @param Request $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $post = $request->request->all();

        $result = array(
            'success' => false,
            'error' => null
        );

        // Valida os parâmetros de login
        if (!$post['username']) {
            $result['error'] = 'Usuário inválido.';
        } else if (!$post['password']) {
            $result['error'] = 'Senha inválida.';
        } else if ($exception->getMessage() == 'Bad credentials.') {
            $result['error'] = 'Acesso não autorizado.';
            return $this->app->json($result);
        } else {
            $result['error'] = $exception->getMessage();
        }

        return $this->app->json($result);
    }
}
