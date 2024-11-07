<?php


class PartidaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function crearPartida($id) {

        if (!empty($id)) {

            if($this->partidaActiva($id)){
                $this->finalizarPartida($id);
            }


            $idUser = $id;
            $sqlInsert = "INSERT INTO partida (usuario_FK) VALUES ('$idUser')";

            $this->database->execute($sqlInsert);



        } else {

            throw new Exception("Usuario no encontrado.");
        }
    }

    public function traerPregunta($resultado_ruleta, $userId) {
        $nivelUsuario = $this->calcularTasaUsuario($userId);

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
            $tiempoEntrega = time();

            $checkSql = "SELECT 1 FROM preguntas_respondidas WHERE usuario_FK = $userId AND pregunta_FK = $preguntaId";
            $checkResult = $this->database->query($checkSql);

            $dificultadPregunta = $this->calcularDificultadPregunta($preguntaId);

            $esAdecuada = false;
            if (($nivelUsuario === 'novato' && $dificultadPregunta === 'facil') ||
                ($nivelUsuario === 'promedio' && $dificultadPregunta === 'facil') ||
                ($nivelUsuario === 'mono' && $dificultadPregunta === 'dificil')) {
                $esAdecuada = true;
            }


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

        $dataModel = [
            $preguntaSeleccionada,
            $tiempoEntrega
        ];

        return $dataModel;
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

    public function sumarPuntuacion($id){

        $sql = "SELECT puntuacion FROM partida WHERE usuario_FK = '$id' AND estado = 1";
        $result = $this->database->query($sql);


        if ($result && count($result) > 0) {
            $puntuacionActual = $result[0]['puntuacion'];


            $puntuacionNueva = $puntuacionActual + 1;


            $sqlUpdate = "UPDATE partida SET puntuacion = '$puntuacionNueva' WHERE usuario_FK = '$id' AND estado = 1";
            $this->database->execute($sqlUpdate);
        } else {
            echo "No se encontró una partida activa para el usuario.";
        }
    }

    public function finalizarPartida($id) {

        if (!empty($id)) {
            $sql = "SELECT puntuacion FROM partida WHERE usuario_FK = '$id' AND estado = 1";
            $result = $this->database->query($sql);
            $puntuacionActual = $result[0]['puntuacion'];

            $sqlPuntuacionUpdate = "UPDATE partida SET puntuacion = '$puntuacionActual' WHERE usuario_FK = '$id' AND estado = 1";
            $this->database->execute($sqlPuntuacionUpdate);

            $sqlEstadoUpdate = "UPDATE partida SET estado = 2 WHERE usuario_FK = '$id' AND estado = 1";
            $this->database->execute($sqlEstadoUpdate);

        } else {

            echo "Error: No se encontró un usuario con el nombre de usuario $id";
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

    public function partidaActiva($id)
    {
     $sql = "SELECT * FROM partida WHERE usuario_FK = $id and estado = 1";
     $result = $this->database->query($sql);

     if(!empty($result)){
         return true;
     }
     return false;
    }

    public function validarTiempoRespuesta($preguntaId) {

        if ($_SESSION['pregunta_id'] !== $preguntaId) {
            return false; // La pregunta no coincide
        }


        $tiempoActual = time();
        $tiempoEntrega = $_SESSION['tiempo_entrega'];
        $diferenciaTiempo = $tiempoActual - $tiempoEntrega;


        return $diferenciaTiempo <= 15;
    }

    function calcularTasa($cantidadVistas, $cantidadCorrectas) {
        if ($cantidadVistas == 0) {
            return 0;
        }
        return $cantidadCorrectas / $cantidadVistas;
    }

    function calcularDificultadPregunta($preguntaId): string
    {

        $sql = "SELECT cantidad_correctas, cantidad_vista FROM pregunta WHERE id = $preguntaId";
        $result = $this->database->query($sql);

        $fila = $result->fetch_assoc();

        $cantidadCorrectas = $fila['cantidad_correctas'];
        $cantidadVista = $fila['cantidad_vista'];


        if($this->calcularTasa($cantidadCorrectas, $cantidadVista) >= 0.7){
            return "facil";
        }
        if($this->calcularTasa($cantidadCorrectas, $cantidadVista) == 0){
            return "dificil";
        }
        if($this->calcularDificultadPregunta($preguntaId) < 0.3){
            return "dificil";
        }
        else {
            return "facil";
        }

    }

    function calcularTasaUsuario($usuarioId): string
    {
        $sql = "SELECT cantidad_preg_vistas, cantidad_preg_correctas FROM pregunta WHERE id = $usuarioId";
        $result = $this->database->query($sql);

        $fila = $result->fetch_assoc();

        $cantidadCorrectas = $fila['cantidad_preg_correctas'];
        $cantidadVista = $fila['cantidad_preg_vistas'];

        if($this->calcularTasa($cantidadCorrectas, $cantidadVista) < 0.5){
            return "novato";
        }

        if($this->calcularTasa($cantidadCorrectas, $cantidadVista) >= 0.7){
            return "mono"; // capo
        }
        else {
            return "promedio";
        }
    }

}