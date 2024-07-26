<?php

namespace Controllers;

use Model\Agenda;
use MVC\Router;


class AgendaController
{
    public static function index(Router $router)
    {

        if (!is_Auth()) {
            header('Location: /');
        }

        $router->render(
            'dashboard/agenda/index',
            [
                'titulo' => 'Agenda'
            ]
        );
    }

    public static function store()
    {

        if (!is_Auth()) {
            header('Location: /');
        }
        $evento = new Agenda;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evento->sincronizar($_POST);
            $evento->usuarioId = $_SESSION['id'];
            
            $resultado = $evento->guardar();
            if($resultado){
                echo json_encode(['Evento Agendado' => $evento]);
                return;
            }
            http_response_code(400);
            echo json_encode(['error' => 'Error Agendar un Evento']);
            return;
        }
    }
}
