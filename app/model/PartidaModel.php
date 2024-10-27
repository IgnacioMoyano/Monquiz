<?php


class PartidaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function crearPartida($username) {

        $sql = "SELECT id FROM usuario WHERE username = '$username'";
        $result = $this->database->query($sql);


        if (!empty($result)) {

            $idUser = $result[0]['id'];
            $sqlInsert = "INSERT INTO partida (usuario_FK) VALUES ('$idUser')";

            $this->database->execute($sqlInsert);



        } else {

            throw new Exception("Usuario no encontrado.");
        }
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

    public function respuestaCorrecta($idRespuesta){

        $sql = "SELECT id FROM respuesta WHERE id = $idRespuesta and es_correcta = 1 ";

        $result = $this->database->query($sql);

        return $result[0] ?? null;


    }

    public function sumarPuntuacion($puntuacion){

       $puntuacion += 1;

       return $puntuacion;
    }

    public function finalizarPartida($puntuacion, $username) {
        $sqlUserId = "SELECT id FROM usuario WHERE username = '$username'";
        $result = $this->database->query($sqlUserId);


        if (!empty($result)) {
            $userId = $result[0]['id'];

            $sqlPuntuacionUpdate = "UPDATE partida SET puntuacion = $puntuacion WHERE usuario_FK = $userId AND estado = 1";
            $this->database->execute($sqlPuntuacionUpdate);

            $sqlEstadoUpdate = "UPDATE partida SET estado = 2 WHERE usuario_FK = $userId AND estado = 1";
            $this->database->execute($sqlEstadoUpdate);

        } else {

            echo "Error: No se encontró un usuario con el nombre de usuario $username";
        }
    }

}