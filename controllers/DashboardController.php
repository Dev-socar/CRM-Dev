<?php

namespace Controllers;

use Model\Agenda;
use Model\Cliente;
use Model\Usuario;
use MVC\Router;

class DashboardController
{

    public static function index(Router $router)
    {
        if (!is_Auth()) {
            header('Location: /');
        }

        $clientes = Cliente::ordenarLimiteWhere('usuarioId', $_SESSION['id'], 'DESC', 5);
        $eventos = Agenda::ordenarLimiteWhere('usuarioId', $_SESSION['id'], 'DESC', 5);
        if (is_Admin()) {
            $empleados = Usuario::ordenarLimiteWhere('admin', 0, 'DESC', 5);
        }else{
            $empleados = null;
        }



        $router->render(
            'dashboard/panel/index',
            [
                'titulo' => 'Dashboard',
                'clientes' => $clientes,
                'eventos' => $eventos,
                'empleados' => $empleados
            ]
        );
    }
}
