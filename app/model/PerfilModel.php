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
}