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

    public function getPuntajeMaximo($userId) {
        $sql = "SELECT MAX(puntuacion) AS max_puntuacion FROM partida WHERE usuario_FK = '$userId'";
        $result = $this->database->query($sql);


        if ($result && count($result) > 0) {
            return $result[0]['max_puntuacion'];
        }

        return null;
    }
}