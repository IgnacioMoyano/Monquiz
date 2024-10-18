<?php

class UsuarioController
{

    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function createUser()
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        $fecha_nac = $_POST['fecha_nac'];
        $genero = $_POST['genero'];
        $direccion = $_POST['direccion'];
        $foto = "poto";
        $nombre_usuario = $_POST['nombre_usuario'];
        $pass2 = $_POST['rep_password'];

        if ($this->model->validatePassword($pass, $pass2)){
            $validation = $this->model->createUser($user, $pass, $email, $fecha_nac, $genero, $direccion, $foto, $nombre_usuario);

            if ($validation) {
                $_SESSION['user'] = $user;
            }
        }

        $this->presenter->show("login");
        exit();
    }

    public function auth()
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $validation = $this->model->validate($user, $pass);

        if ($validation) {
            $_SESSION['user'] = $user;
        }

        header('location: /pokedex');
        exit();
    }

    public function login(){
        $this->presenter->show("login");
    }

    public function list(){
        $this->presenter->show("register");
    }


}