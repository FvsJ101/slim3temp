<?php

namespace App\Middleware;

class UserAuthMiddleware extends Middleware
{
    
    public function __invoke($request, $response, $next)
    {
        
        if (isset($_SESSION['user'])) {
            $this->container->view->getEnvironment()->addGlobal('auth', array(
              'checked'  => $this->container->auth->checkUserLoggedIn(),
              'userInfo' => $this->container->auth->userInfo()
            ));
        }
        
        $response = $next($request, $response);
        
        return $response;
        
    }
    
}