<?php

namespace Model;

use Model\ActiveRecord;

class Cliente extends ActiveRecord
{
    protected static $tabla = "clientes";
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'direccion', 'usuarioId'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $direccion;
    public $usuarioId;
    public $empleado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? null;
    }
}
