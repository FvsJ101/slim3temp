<?php

namespace App\Middleware;

class BreadCrumbs extends Middleware
{
    
    public function __invoke($request, $response, $next)
    {
        
        unset($_SESSION['breadCrumbs']);
        //ALWAYS BE HOME
        $_SESSION['breadCrumbs'] [] = array("route" => "Home", "uri" => "home");
        
        //GET THE NAME OF CURRENT SELECTED PAGE
        $routeName = $request->getAttribute('route')->getName();
        
        //BUILD BREADCRUMBS
        switch ($routeName) {
            case "contact":
                $_SESSION['breadCrumbs'] [] = array("route" => "Contact us", "uri" => $routeName, "active" => "active");
                break;
            case "auth.signup":
                $_SESSION['breadCrumbs'] [] = array("route"  => "Registration",
                                                    "uri"    => $routeName,
                                                    "active" => "active"
                );
                $_SESSION['breadCrumbs'] [] = array("route" => "Register", "uri" => $routeName, "active" => "active");
                break;
            case "auth.signin":
                $_SESSION['breadCrumbs'] [] = array("route"  => "Registration",
                                                    "uri"    => $routeName,
                                                    "active" => "active"
                );
                $_SESSION['breadCrumbs'] [] = array("route" => "Sign In", "uri" => $routeName, "active" => "active");
                break;
            case "about":
                $_SESSION['breadCrumbs'] [] = array("route" => "About us", "uri" => $routeName, "active" => "active");
                break;
            case "service":
                $_SESSION['breadCrumbs'] [] = array("route" => "Services", "uri" => $routeName, "active" => "active");
                break;
            case "auth.profile":
                $_SESSION['breadCrumbs'] [] = array("route" => "Profile", "uri" => $routeName, "active" => "active");
                break;
        }
        
        //ALLOW VIEW TO USE IT
        $this->container->view->getEnvironment()->addGlobal('breadCrumbs', $_SESSION['breadCrumbs']);
        $response = $next($request, $response);
        
        return $response;
        
    }
    
}