<?php


class EditorModel
{
    private $database;
    public function __construct($database){
        $this->database = $database;
    }

    public function getAllPreguntas(){
        $sql = "SELECT p.*, c.descripcion AS categoria, e.descripcion AS estado FROM pregunta p JOIN categoria c ON c.id = p.categoria_FK JOIN estado e ON e.id = p.estado_FK ORDER BY p.id ASC";
        $result = $this->database->query($sql);

        return $result;
    }

    public function getPreguntasReportadas(){
        $sql = "SELECT p.*, c.descripcion AS categoria, e.descripcion AS estado FROM pregunta p JOIN categoria c ON c.id = p.categoria_FK JOIN estado e ON e.id = p.estado_FK WHERE p.reportada = 1  ORDER BY p.id ASC";
        $result = $this->database->query($sql);

        return $result;
    }

    public function getPreguntasPendientes(){
        $sql = "SELECT p.*, c.descripcion AS categoria, e.descripcion AS estado FROM pregunta p JOIN categoria c ON c.id = p.categoria_FK JOIN estado e ON e.id = p.estado_FK WHERE p.estado_FK = 1  ORDER BY p.id ASC";
        $result = $this->database->query($sql);

        return $result;
    }

    public function getPregunta($id){
//        $sql = "SELECT p.*, c.descripcion AS categoria, e.descripcion AS estado,r.respuesta AS respuesta, r.es_correcta AS correcta FROM pregunta p JOIN categoria c ON c.id = p.categoria_FK JOIN estado e ON e.id = p.estado_FK JOIN respuesta r ON r.pregunta_FK = p.id WHERE p.id = $id";
        $sql = "SELECT p.*, c.descripcion AS categoria, e.descripcion AS estado FROM pregunta p JOIN categoria c ON c.id = p.categoria_FK JOIN estado e ON e.id = p.estado_FK WHERE p.id = $id";
        $result = $this->database->query($sql);

        return $result[0];
    }

    public function getRespuestas($id){
        $sql = "SELECT respuesta, es_correcta FROM respuesta WHERE pregunta_FK = $id";

        $result = $this->database->query($sql);
        return $result;
    }


    public function actualizarPregunta($datosPregunta)
    {

        $id = $datosPregunta['id'];
        $pregunta = $datosPregunta['pregunta'];
        $categoria_FK = $datosPregunta['categoria_FK'];
        $estado_FK = $datosPregunta['estado_FK'];
        $reportada = $datosPregunta['reportada'];
        $cantidad_vista = $datosPregunta['cantidad_vista'];
        $cantidad_correctas = $datosPregunta['cantidad_correctas'];
        $creada_usuarios = $datosPregunta['creada_usuarios'];
        $respuestas = $datosPregunta['respuestas'];
        $respuestaCorrecta = $datosPregunta['respuesta_correcta'];


        $sqlPregunta = "UPDATE pregunta SET
        pregunta = '$pregunta',
        categoria_FK = '$categoria_FK',
        estado_FK = '$estado_FK',
        reportada = '$reportada',
        cantidad_vista = '$cantidad_vista',
        cantidad_correctas = '$cantidad_correctas',
        creada_usuarios = '$creada_usuarios'
        WHERE id = '$id'";


         $this->database->execute($sqlPregunta);

        $indice = 0;


        $this->database->execute("DELETE FROM respuesta WHERE pregunta_FK = $id");
        foreach ($respuestas as $respuesta) {
            $indice = $indice + 1;

            if($indice == 1){
                $sqlRespuesta = "INSERT INTO respuesta (pregunta_FK, respuesta, es_correcta) 
                         VALUES ('$id', '$respuesta',1)";
            } else{
                $sqlRespuesta = "INSERT INTO respuesta (pregunta_FK, respuesta, es_correcta) 
                         VALUES ('$id', '$respuesta',0)";
            }

            $this->database->execute($sqlRespuesta);

        }

        return true;
    }
}