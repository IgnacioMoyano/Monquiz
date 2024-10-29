<?php

class UsuarioModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function createUser($name, $pass, $email, $fecha_nac, $genero, $pais, $ciudad, $foto, $username,$validado,$token){

        if (empty($name) || empty($pass) || empty($email) || empty($fecha_nac) || empty($username)) {
            return "Todos los campos son obligatorios";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "El email no es válido";
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $name) || strlen($name) > 30) {
            return "El nombre no es válido";
        }

        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/", $pass)) {
            return "La contraseña no es válida";
        }

        if(!$this->validarUsuario($email, $username)){
            return "El usuario ya existe";
        }


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
        $sql = "SELECT id,username,imagen 
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

    public function validarUsuario($email, $username): bool
    {
        $sql = "SELECT 1 FROM usuario WHERE correo = '$email' OR username = '$username'";
        $result = $this->database->query($sql);

        if ($result->num_rows > 0) {
            return false;
        }
        return true;
    }

}