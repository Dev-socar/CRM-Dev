<?php

namespace Model;

use Model\ActiveRecord;

class Agenda extends ActiveRecord
{
    protected static $tabla = "agenda";
    protected static $columnasDB = ['id', 'usuarioId', 'title', 'start', 'end', 'textColor', 'backgroundColor'];
    public $id;
    public $usuarioId;
    public $title;
    public $start;
    public $end;
    public $textColor;
    public $backgroundColor;
    public $empleado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->usuarioId = $args['usuarioId'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->start = $args['start'] ?? '';
        $this->end = $args['end'] ?? null;
        $this->textColor = $args['textColor'] ?? '';
        $this->backgroundColor = $args['backgroundColor'] ?? '';
    }
}
