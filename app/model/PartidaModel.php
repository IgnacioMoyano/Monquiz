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

    public function traerPregunta($resultado_ruleta, $userId) {
        $sql = "SELECT id, pregunta FROM pregunta WHERE categoria_FK = $resultado_ruleta";
        $result = $this->database->query($sql);

        $count = count($result);
        if ($count == 0) {
            return null;
        }

        $preguntaSeleccionada = null;
        $intentos = 0;

        do {
            $random = random_int(0, $count - 1);
            $preguntaSeleccionada = $result[$random];
            $preguntaId = $preguntaSeleccionada['id'];


            $checkSql = "SELECT 1 FROM preguntas_respondidas WHERE usuario_FK = $userId AND pregunta_FK = $preguntaId";
            $checkResult = $this->database->query($checkSql);

            $intentos++;
            if ($intentos > $count) {

                $deleteSql = "DELETE FROM preguntas_respondidas WHERE usuario_FK = $userId AND pregunta_FK IN (SELECT id FROM pregunta WHERE categoria_FK = $resultado_ruleta)";
                $this->database->execute($deleteSql);
                $intentos = 0;
            }
        } while (!empty($checkResult));


        $insertSql = "INSERT INTO preguntas_respondidas (usuario_FK, pregunta_FK) VALUES ($userId, $preguntaId)";
        $this->database->execute($insertSql);


        $updateSql = "UPDATE pregunta SET cantidad_vista = cantidad_vista + 1 WHERE id = $preguntaId";
        $this->database->execute($updateSql);

        return $preguntaSeleccionada;
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

        if($this->preguntaRespuestaExitosa($idRespuesta)){

            return $result[0];
        }

        return null;


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

    public function preguntaRespuestaExitosa($idRespuesta) {

        $sql = "SELECT pregunta_FK FROM respuesta WHERE id = $idRespuesta AND es_correcta = 1";
        $result = $this->database->query($sql);

        if ($result != null && count($result) > 0) {

            $preguntaId = $result[0]['pregunta_FK'];


            $updateSql = "UPDATE pregunta SET cantidad_correctas = cantidad_correctas + 1 WHERE id = $preguntaId";
            $this->database->execute($updateSql);

            return true;
        }

        return false;
    }

    public function enviarReporte($idPreguntaReportada, $descripcion, $idUser){

        $sql = "INSERT INTO reporte (pregunta_FK, usuario_FK, descripcion) VALUES ($idPreguntaReportada, $idUser,'$descripcion')";
        $this->database->execute($sql);

        $sqlUpdate = "UPDATE pregunta SET reportada = 1 WHERE id = $idPreguntaReportada";
        $this->database->execute($sqlUpdate);
    }

}