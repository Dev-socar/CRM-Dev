<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Paginacion;

class UsuariosController
{

    public static function index(Router $router)
    {
        if (!is_Auth()) {
            header('Location: /');
        }
        if (!is_Admin()) {
            header('Location: /dashboard/panel');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /dashboard/empleados?page=1');
        }
        $registros_por_pagina = 6;
        $total_registros = Usuario::total('admin', 0);
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /dashboard/empleados?page=1');
        }


        $empleados = Usuario::paginarWhereAll('admin', 0,$registros_por_pagina, $paginacion->offset());


        $router->render(
            'dashboard/empleados/index',
            [
                'titulo' => 'Empleados',
                'empleados' => $empleados,
                'paginacion' => $paginacion->paginacion()
            ]
        );
    }

    public static function agregar(Router $router)
    {
        if (!is_Auth()) {
            header('Location: /');
        }
        if (!is_Admin()) {
            header('Location: /dashboard/panel');
        }

        $usuario = new Usuario;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $usuarioExiste = Usuario::where('email', $usuario->email);
            //verificamos si ese usuario existe
            if ($usuarioExiste) {
                //si existe mostramos un error
                http_response_code(400);
                echo json_encode(['error' => 'El Correo Ya Esta En Uso.']);
                return;
            }
            //HashearPassword
            $usuario->hashearPassword();
            $resultado = $usuario->guardar();

            if ($resultado) {
                http_response_code(200);
                echo json_encode(['Cliente Agregado' => $usuario]);
                return;
            }

            http_response_code(400);
            echo json_encode(['error' => 'Error en Crear un Empleado']);
            return;
        }


        $router->render(
            'dashboard/empleados/agregar',
            [
                'titulo' => 'Agregar Empleado',
                'usuario' => $usuario
            ]
        );
    }


    public static function editar(Router $router)
    {
        if (!is_Auth()) {
            header('Location: /');
            exit;
        }
        if (!is_Admin()) {
            header('Location: /dashboard/panel');
            exit;
        }




        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID invalido']);
                exit;
            }

            $usuario = Usuario::find($id);
            if (!$usuario) {
                header('Location: /dashboard/empleados');
                exit;
            }
            // Verifica si el email ya está en uso
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
            if ($resultado) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Empleado Editado Correctamente']);
                exit;
            }
            http_response_code(500);
            echo json_encode(['error' => 'Error al Editar Empleado']);
            exit;
        }

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /dashboard/empleados');
            exit;
        }
        $usuario = Usuario::find($id);
        if (!$usuario) {
            header('Location: /dashboard/empleados');
            exit;
        }

        $router->render(
            'dashboard/empleados/editar',
            [
                'titulo' => 'Editar Empleado',
                'empleado' => $usuario
            ]
        );
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_Auth()) {
                header('Location: /');
            }
            if (!is_Admin()) {
                header('Location: /dashboard/panel');
                exit;
            }

            $id = $_POST['id'];
            $usuario = Usuario::find($id);
            if (!isset($usuario)) {
                http_response_code(404);
                echo json_encode(['error' => 'Empleado no encontrado']);
                return;
            }
            $resultado = $usuario->eliminar();
            if ($resultado) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Empleado Eliminado Correctamente']);
                exit;
            }
        }
    }
}
