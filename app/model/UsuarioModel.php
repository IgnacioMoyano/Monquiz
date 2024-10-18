<?php

class UsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function validatePassword($pass, $pass2){
        return $pass == $pass2;
    }

    public function createUser($user, $pass, $email, $fecha_nac, $genero, $direccion, $foto, $nombre_usuario){
        $sql = "INSERT INTO usuario (username, imagen,password, correo, fecha_nac, genero, direccion, nombre_usuario) 
                VALUES ('" . $user . "', '" . $foto . "', '" . $pass . "', '" . $email . "', '" . $fecha_nac . "', '" . $genero . "', '" . $direccion . "', '" . $nombre_usuario . "');";

        return $this->database->execute($sql);
    }

    public function validateLogin($user, $pass)
    {
        $sql = "SELECT 1 
                FROM usuario 
                WHERE username = '" . $user. "' 
                AND password = '" . $pass . "'";

        $usuario = $this->database->query($sql);

        return sizeof($usuario) == 1;
    }

}