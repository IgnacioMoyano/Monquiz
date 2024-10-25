<?php

class LobbyModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

//    public function getPuntajeMaximo($userId) {
//        $sql = "SELECT cantidad_preg_correctas FROM usuario WHERE id = '$userId'";
//        $result = $this->database->query($sql);
//
//        if ($result === false) {
//            echo "Error en la consulta: " . $this->database->error;
//            return 1;
//        }
//
//        if ($result->num_rows > 0) {
//            $row = $result->fetch_assoc();
//            return $row['cantidad_preg_correctas'];
//        }
//
//        return 0;
//    }


}