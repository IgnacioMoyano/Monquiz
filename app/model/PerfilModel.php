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
        $sql = "SELECT cantidad_preg_correctas FROM usuario WHERE username = '$username'";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_preg_correctas'];

    }
}