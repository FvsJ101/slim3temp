<?php

namespace App\Controllers\Home;

use App\Controllers\Controller;

class HomeController extends Controller
{
    
    public function index($request, $response)
    {
        
        return $this->view->render($response, 'home.twig');
    }
    
}