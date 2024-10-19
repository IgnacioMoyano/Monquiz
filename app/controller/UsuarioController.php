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
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        $fecha_nac = $_POST['fecha_nac'];
        $genero = $_POST['genero'];
        $direccion = $_POST['direccion'];
        $username = $_POST['username'];
        $pass2 = $_POST['rep_password'];
        $foto = $_FILES['foto_perfil'] ?? null;


        if ($this->model->validatePassword($pass, $pass2)){
            $validation = $this->model->createUser($name, $pass, $email, $fecha_nac, $genero, $direccion, $foto, $username);

            if ($validation) {
                $_SESSION['user'] = $username;
            }
        }

        $this->presenter->show("login");
        exit();
    }

    public function auth()
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $validation = $this->model->validateLogin($user, $pass);

        if ($validation) {
            $_SESSION['user'] = $user;
        }


        header('location: /Monquiz/app/usuario/register');
        exit();
    }

    public function login(){
        $data = [];
        if (isset($_SESSION['user'])) {
            $data['user'] = $_SESSION['user'];
        }
        $this->presenter->show("login",$data);
    }

    public function register(){
        $data = [];
        if (isset($_SESSION['user'])) {
            $data['user'] = $_SESSION['user'];
        }
        $this->presenter->show("register",$data);
    }

    public function logout(){
        session_unset();
        session_destroy();
        header('Location: /Monquiz/app/usuario/login');
        exit();
    }



}