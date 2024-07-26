<?php

namespace Controllers;

use MVC\Router;
use Model\Cliente;
use Model\Usuario;
use Classes\Paginacion;

class ClientesController
{
    public static function index(Router $router)
    {
        if (!is_Auth()) {
            header('Location: /');
            exit;
        }

        // Validar página actual
        $pagina_actual = isset($_GET['page']) ? filter_var($_GET['page'], FILTER_VALIDATE_INT) : 1;
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /dashboard/clientes?page=1');
            exit;
        }

        $registros_por_pagina = 7;

        // Inicializar total_registros
        if (is_Admin()) {
            $total_registros = Cliente::total();
        } else {
            $total_registros = Cliente::total('usuarioId', $_SESSION['id']);
        }

        // Inicializar $paginacion siempre
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);

        // Si no hay registros, asignar página actual a 1 y evitar redirección
        if ((int)$total_registros === 0) {
            $pagina_actual = 1;
        } else {
            if ($paginacion->total_paginas() < $pagina_actual) {
                header('Location: /dashboard/clientes?page=1');
                exit;
            }
        }

        // Obtener clientes paginados
        if (is_Admin()) {
            $clientes = Cliente::paginar($registros_por_pagina, $paginacion->offset());
            $admin = Usuario::find($_SESSION['id']);
            foreach ($clientes as $cliente) {
                // debuguear($cliente);
                $empleado = Usuario::find($cliente->usuarioId);
                $cliente->empleado = $empleado ? $empleado->nombre : $admin->nombre;
                $cliente->usuarioId = $empleado ? '' : $admin->id;
            }
        } else {
            $clientes = Cliente::paginarWhereAll('usuarioId', $_SESSION['id'], $registros_por_pagina, $paginacion->offset());
        }

        $router->render(
            'dashboard/clientes/index',
            [
                'titulo' => 'Clientes',
                'clientes' => $clientes ?? [], // Asegurarse de que $clientes esté definido
                'paginacion' => $paginacion->paginacion() // Asegurarse de que $paginacion esté definido
            ]
        );
    }




    public static function agregar(Router $router)
    {
        if (!is_Auth()) {
            header('Location: /');
        }

        $cliente = new Cliente;
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!is_Auth()) {
                header('Location: /');
            }

            $cliente->sincronizar($_POST);
            $clienteExiste = Cliente::whereUnion('usuarios', 'email', $_POST['email']);

            //verificamos si ese usuario existe
            if ($clienteExiste) {
                //si existe mostramos un error
                http_response_code(400);
                echo json_encode(['error' => 'El Correo Ya Esta En Uso.']);
                return;
            }

            $cliente->usuarioId = $_SESSION['id'];
            $resultado = $cliente->guardar();
            if ($resultado) {
                echo json_encode(['Cliente Agregado' => $cliente]);
                return;
            }
            http_response_code(400);
            echo json_encode(['error' => 'Error en Crear un Cliente']);
            return;
        }

        $router->render(
            'dashboard/clientes/agregar',
            [
                'titulo' => 'Agregar Cliente'
            ]
        );
    }



    public static function editar(Router $router)
    {

        if (!is_Auth()) {
            http_response_code(401);
            echo json_encode(['error' => 'No Autorizado']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID invalido']);
                exit;
            }
            $cliente = Cliente::find($id);
            if (!$cliente) {
                http_response_code(404);
                echo json_encode(['error' => 'Cliente no encontrado']);
                exit;
            }

            // Verifica si el email ya está en uso
            $emailExiste = Cliente::whereUnion('usuarios', 'email', $_POST['email']);
            if ($emailExiste && $emailExiste->id != $cliente->id) {
                http_response_code(400);
                echo json_encode(['error' => 'El Correo Ya Esta En Uso']);
                exit;
            }

            $cliente->nombre = $_POST['nombre'];
            $cliente->apellido = $_POST['apellido'];
            $cliente->email = $_POST['email'];
            $cliente->telefono = $_POST['telefono'];
            $cliente->direccion = $_POST['direccion'];

            $resultado = $cliente->guardar();
            if ($resultado) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Cliente Editado Correctamente']);
                exit;
            }

            http_response_code(500);
            echo json_encode(['error' => 'Error al Editar Cliente']);
            exit;
        }


        $id = filter_var((int)$_GET['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID invalido']);
            exit;
        }

        $cliente = Cliente::find($id);
        if (!$cliente) {
            http_response_code(404);
            echo json_encode(['error' => 'Cliente no encontrado']);
            exit;
        }
        $router->render(
            'dashboard/clientes/editar',
            [
                'titulo' => 'Editar Cliente',
                'cliente' => $cliente
            ]
        );
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_Auth()) {
                header('Location: /');
            }
            $id = $_POST['id'];
            $cliente = Cliente::find($id);
            if (!isset($cliente)) {
                http_response_code(404);
                echo json_encode(['error' => 'Cliente no encontrado']);
                return;
            }
            $resultado = $cliente->eliminar();
            if ($resultado) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Cliente Eliminado Correctamente']);
                exit;
            }
        }
    }
}
