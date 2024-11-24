<?php
class PerfilModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getPerfil($username) {
        $sql = "SELECT username, correo, fecha_nac, genero, ciudad,pais, imagen FROM usuario WHERE username = '$username'";
        return $this->database->query($sql);
    }

    public function getPuntaje($username){

        $sqlId = "SELECT id FROM usuario WHERE username = '$username'";
        $result = $this->database->query($sqlId);
        $userId = $result[0]["id"];

        $sql = "SELECT MAX(puntuacion) AS max_puntuacion FROM partida WHERE usuario_FK = '$userId'";
        $result = $this->database->query($sql);


        return $result[0]['max_puntuacion'];

    }

}