<?php

class LobbyModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPuntajeMaximo($userId) {
        $sql = "SELECT MAX(puntuacion) AS max_puntuacion FROM partida WHERE usuario_FK = '$userId'";
        $result = $this->database->query($sql);


        if ($result && count($result) > 0) {
            return $result[0]['max_puntuacion'];
        }

        return null;
    }

public function guardarSugerencia($pregunta, $categoria, $respuesta_correcta, $respuesta_incorrecta1, $respuesta_incorrecta2, $respuesta_incorrecta3) {


    $sql = "INSERT INTO pregunta (pregunta, categoria_FK, estado_FK, creada_usuarios)  VALUES ('$pregunta', $categoria, 1 ,1)";
    $this->database->execute($sql);

    $preguntaId = $this->getUltimaId("pregunta");

    $respuestas = [
        ['respuesta' => $respuesta_correcta, 'es_correcta' => 1],
        ['respuesta' => $respuesta_incorrecta1, 'es_correcta' => 0],
        ['respuesta' => $respuesta_incorrecta2, 'es_correcta' => 0],
        ['respuesta' => $respuesta_incorrecta3, 'es_correcta' => 0]
    ];


    foreach ($respuestas as $respuesta) {
        $respuestaTexto = $respuesta['respuesta'];
        $esCorrecta = (int)$respuesta['es_correcta'];

        $queryRespuesta = "INSERT INTO respuesta (pregunta_FK, respuesta, es_correcta) 
                           VALUES ($preguntaId, '$respuestaTexto', $esCorrecta)";

        $this->database->execute($queryRespuesta);

    }

    header('Location: /Monquiz/app/lobby/mostrarLobby');

}

    public function getCategorias()
        {
            $sql = "SELECT id, descripcion FROM categoria";
            return $this->database->query($sql);
        }

    public function getUltimaId($tabla) {
        $sql = "SELECT MAX(id) AS ultima_id FROM $tabla";
        $resultado = $this->database->query($sql);

        if ($resultado && isset($resultado[0]['ultima_id'])) {
            return $resultado[0]['ultima_id'];
        } else {
            echo "Error: No se ha obtenido la ID correctamente o el resultado es inválido.";
            return null;
        }

    }


}