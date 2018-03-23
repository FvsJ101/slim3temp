<?php

namespace App\Middleware;

class CsrfViewMiddleware extends Middleware
{
    
    public function __invoke($request, $response, $next)
    {
        
        //ADD TO THE GLOBLE SO WE CAN RETRIEVE IT WITHIN THE VIEWS
        $this->container->view->getEnvironment()->addGlobal('csrf', array(
          'field' => '
                <input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '">
                <input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '">
            ',
        
        ));
        
        $response = $next($request, $response);
        
        return $response;
        
    }
    
}