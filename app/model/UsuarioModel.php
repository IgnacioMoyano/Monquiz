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


        if ($foto && $this->validarMoverFoto($foto)){

            $imagen_nombre = $foto['name'];
            $sql = "INSERT INTO usuario (username, imagen,password, correo, fecha_nac, genero, direccion, nombre_usuario) 
                VALUES ('" . $user . "', '/Monquiz/app/public/images/fotosPerfil/" . $imagen_nombre . "', '" . $pass . "', '" . $email . "', '" . $fecha_nac . "', '" . $genero . "', '" . $direccion . "', '" . $nombre_usuario . "');";

            return $this->database->execute($sql);
        }
        return false;
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

    private function validarMoverFoto($foto)
    {
        $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . "/Monquiz/app/public/images/fotosPerfil/";

        if (isset($foto) && $foto['error'] == 0) {
            $imagen_urlTemp = $foto['tmp_name'];
            $imagen_nombre = $foto['name'];

            if (move_uploaded_file($imagen_urlTemp, $carpeta_destino . $imagen_nombre)) {
                return true;
            }
        }
        return false;
    }

}