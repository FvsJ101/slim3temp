<?php

namespace App\Middleware;

class OldInputMiddleware extends Middleware
{
    
    public function __invoke($request, $response, $next)
    {
        
        if (isset($_SESSION['signUpOld']) && is_array($_SESSION['signUpOld'])) {
            $this->container->view->getEnvironment()->addGlobal('signUpOld', $_SESSION['signUpOld']);
        }
        
        $_SESSION['signUpOld'] = $request->getParams();
        
        $response = $next($request, $response);
        
        return $response;
        
    }
    
}
