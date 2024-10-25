<?php


class JuegoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function traerPregunta($resultado_ruleta){

        $sql = "SELECT id,pregunta FROM pregunta WHERE categoria_FK = $resultado_ruleta";

        $result = $this->database->query($sql);

        $count = count($result);
        $random = random_int(0,$count-1);

        return $result[$random] ?? null;
    }
    public function traerRespuesta($id_pregunta){
    $sql = "SELECT id,respuesta FROM respuesta WHERE pregunta_FK = $id_pregunta";

    $result = $this->database->query($sql);

    return $result ?? null;
    }

    public function traerCategoria($resultado_ruleta) {
        $sql = "SELECT descripcion, color FROM categoria WHERE id = $resultado_ruleta";

        $result = $this->database->query($sql);

        return $result[0] ?? null;
    }


}