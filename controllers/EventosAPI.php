<?php

namespace Controllers;

use Model\Agenda;
use Model\Usuario;;


class EventosAPI
{
    public static function index()
    {

        if (!is_Auth()) {
            header('Location: /');
        }
        if (is_Admin()) {
            $eventos = Agenda::all();
        } else {
            $eventos = Agenda::whereAll('usuarioId', $_SESSION['id']);
        }
        echo json_encode($eventos);
        return;
    }

    public static function evento()
    {
        if (!is_Auth()) {
            header('Location: /');
        }
        $id = filter_var((int)$_GET['id'], FILTER_VALIDATE_INT);
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID invalido']);
            exit;
        }
        $evento = Agenda::where('id', $id);
        if (!$evento) {
            http_response_code(400);
            echo json_encode(['error' => 'No Existe este Evento']);
            exit;
        }
        if (is_Admin()) {
            $empleado = Usuario::where('id', $evento->usuarioId);
            $evento->empleado = $empleado->nombre;
        }

        echo json_encode($evento);
        return;
    }

    public static function editar()
    {
        if (!is_Auth()) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID invalido']);
                exit;
            }
            $evento = Agenda::find($id);
            if (!$evento) {
                http_response_code(404);
                echo json_encode(['error' => 'Evento no encontrado']);
                exit;
            }

            $evento->start = $_POST['start'];
            $evento->end = !empty($_POST['end']) ? $_POST['end'] : null;
            $resultado = $evento->guardar();

            if ($resultado) {
                echo json_encode(['mensaje' => 'Evento actualizado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al actualizar el evento']);
            }
        }
    }
}
