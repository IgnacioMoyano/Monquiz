<?php

class UsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function createUser($name, $pass, $email, $fecha_nac, $genero, $pais, $ciudad, $foto, $username,$validado,$token){


        if ($foto && $this->validarMoverFoto($foto)){

            $imagen_nombre = $foto['name'];
            $sql = "INSERT INTO usuario (name, imagen,password, correo, fecha_nac, genero, pais, ciudad, username,validado,token) 
                VALUES ('" . $name . "', '/Monquiz/app/public/images/fotosPerfil/" . $imagen_nombre . "', '" . $pass . "', '" . $email . "', '" . $fecha_nac . "', '" . $genero . "', '" . $pais . "', '" . $ciudad . "', '" . $username . "', '" . $validado . "', '" . $token . "');";

            return $this->database->execute($sql);
        }
        return false;
    }

    public function validateLogin($user, $pass)
    {
        $sql = "SELECT imagen, username   
                FROM usuario 
                WHERE username = '" . $user. "' 
                AND password = '" . $pass . "'";

        $usuario = $this->database->query($sql);

        return $usuario[0] ?? null;
    }

    public function validarMoverFoto($foto)
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

    public function validarToken($id, $token){

        $query = "SELECT token FROM usuario WHERE id = $id";
        $resultado = $this->database->query($query);
        $tokenUsuario =  isset($resultado[0]) ? $resultado[0]['token'] : null;


        if ($tokenUsuario === $token) {

            $updateQuery = "UPDATE usuario SET validado = 1 WHERE id = $id";
            $this->database->execute($updateQuery);



            return true;

        }

        return false;

}

    public function getUserIdByEmail($username) {
        $sql = "SELECT id FROM usuario WHERE username = '$username'";
        $result = $this->database->query($sql);
        return isset($result[0]) ? $result[0]['id'] : null; // Devuelve el ID o null
    }

    public function getTokenById($userId) {
        $sql = "SELECT token FROM usuario WHERE id = '$userId'";
        $result = $this->database->query($sql);
        return isset($result[0]) ? $result[0]['token'] : null; // Devuelve el token o null
    }


    public function validateFields($name, $pass, $email, $fecha_nac, $username)
    {
        $fechaHoy = new DateTime();

        if(!preg_match('/^[a-zA-Z]+$/', $name)){
            return "El nombre solo puede contener letras";
        }

        if ($fecha_nac > $fechaHoy) {
            return "La fecha de nacimiento no puede ser mayor a la fecha actual";
        }

        if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
            return "El nombre de usuario solo puede contener letras, números y guiones bajos";
        }

        if(strlen($pass) <= 10 && !preg_match('/[A-Z]/', $pass) && !preg_match('/[a-z]/', $pass) ){
            return "La contraseña debe tener al menos 10 caracteres, una mayúscula y una minúscula";
        }

        return null;
    }
}