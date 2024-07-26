<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class PerfilController
{

    public static function index(Router $router)
    {
        if (!is_Auth()) {
            header('Location: /');
            exit;
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID invalido']);
                exit;
            }
            $usuario = Usuario::find($_SESSION['id']);
            if (!$usuario) {
                header('Location: /dashboard/panel');
                exit;
            }

            $emailExiste = Usuario::whereUnion('clientes', 'email', $_POST['email']);
            if ($emailExiste && $emailExiste->id != $usuario->id) {
                http_response_code(400);
                echo json_encode(['error' => 'El Correo Ya Esta En Uso']);
                exit;
            }
            // Verifica y hashea la nueva contraseña si se proporciona
            if (!empty($_POST['password'])) {
                $usuario->password = $_POST['password'];
                $usuario->hashearPassword();
            }
            $usuario->nombre = $_POST['nombre'];
            $usuario->email = $_POST['email'];
            $usuario->telefono = $_POST['telefono'];
            $resultado = $usuario->guardar();
            $_SESSION['nombre'] = $usuario->nombre;
            if ($resultado) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Empleado Editado Correctamente']);
                exit;
            }
            http_response_code(500);
            echo json_encode(['error' => 'Error al Editar Empleado']);
            exit;
        }

        $usuario = Usuario::find($_SESSION['id']);
        if (!$usuario) {
            header('Location: /dashboard/panel');
            exit;
        }


        $router->render(
            'dashboard/perfil/index',
            [
                'titulo' => 'Ajustes',
                'empleado' => $usuario
            ]
        );
    }
}
