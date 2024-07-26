<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;

class LoginController
{
    public static function login(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $usuario = new Usuario($_POST);

            //Validando si existe usuario
            $usuario = Usuario::where('email', $usuario->email);
            if ($usuario) {
                //Comprobamos Password
                if (password_verify($_POST['password'], $usuario->password)) {
                    //verificamos si es admin
                    session_start();
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;
                    if ($usuario->admin) {
                        $_SESSION['admin'] = true;
                    } else {
                        $_SESSION['admin'] = false;
                    }
                    $usuario->estado = '1';
                    $usuario->guardar();
                    http_response_code(200);
                    echo json_encode(['response' => 'ok']);
                    return;
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Password incorrecto']);
                    return;
                }
                return;
            }
            // Devolver un código de estado 404 para el error
            http_response_code(404);
            echo json_encode(['error' => 'Usuario No Encontrado']);
            return;
        }

        $router->render(
            'auth/login',
            [
                'titulo' => 'Login'
            ]
        );
    }



    public static function logout()
    {
        if (!is_Auth()) {
            header('Location: /');
        }
        if (isset($_SESSION['id'])) {
            $usuario = Usuario::find($_SESSION['id']);
            if ($usuario) {
                $usuario->estado = '0';
                $usuario->guardar();
            }
        }
        session_start();
        $_SESSION = [];
        header('Location:/');
    }
}
