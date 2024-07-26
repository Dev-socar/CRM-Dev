<?php

namespace Controllers;

use MVC\Router;



class PaginaError
{
    public static function index(Router $router)
    {

        
        $router->render(
            'layout-error',
            [
                'titulo' => '404'
            ]
        );
    }



    
}
