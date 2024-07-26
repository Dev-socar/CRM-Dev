<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord
{
    protected static $tabla = "usuarios";
    protected static $columnasDB = ['id', 'nombre', 'email', 'telefono', 'password', 'admin', 'estado'];

    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $password;
    public $admin;
    public $estado;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->estado = $args['estado'] ?? 0;
    }

    public function hashearPassword()
    {
        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }
    }

    //generar Token
    public function token()
    {
        $this->token = md5(uniqid());
    }
}
