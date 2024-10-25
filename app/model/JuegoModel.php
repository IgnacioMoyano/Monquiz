<?php


class JuegoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function traerPregunta(){

    }

    public function traerCategoria($resultado_ruleta) {
        $sql = "SELECT descripcion, color FROM categoria WHERE id = $resultado_ruleta";

        $result = $this->database->query($sql);

        return $result[0] ?? null;
    }
}