<?php

class UsuarioController
{

    private $model;
    private $presenter;
    private $emailSender;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->emailSender = new EmailSender();
    }

    public function createUser()
    {
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        $fecha_nac = $_POST['fecha_nac'];
        $genero = $_POST['genero'];
        $pais = $_POST['pais'];
        $ciudad = $_POST['ciudad'];
        $username = $_POST['username'];
        $pass2 = $_POST['rep_password'];
        $foto = $_FILES['foto_perfil'] ?? null;
        $token = random_int(1, 10000);
        $validado = 0;

        if ($this->validatePassword($pass, $pass2)){

            if ($this->model->validateFields($name, $pass, $email, $fecha_nac, $username)) {

                $validationCreateUser = $this->model->createUser($name, $pass, $email, $fecha_nac, $genero, $pais, $ciudad, $foto, $username, $validado, $token);

                if ($validationCreateUser) {
                    $_SESSION['username'] = $username;

                    $userId = $this->model->getUserIdByEmail($username);
                    $subject = "Validación de cuenta";
                    $body = "Gracias por registrarte. Por favor, valida tu cuenta haciendo clic en el siguiente enlace.\n";

                    $this->emailSender->send($email, $subject, $body, $userId, $token);
                    $this->presenter->show("login");
                }
            } else {
                $data['error'] =  "Faltan campos por completar";
                $this->presenter->show("register", $data);
            }

        } else {

            $data['error'] =  "Las contraseñas no coinciden";

            $this->presenter->show("register", $data);
        }

        $this->presenter->show("register");
        exit();
    }

    public function auth()
    {
        $username = $_POST['username'];
        $pass = $_POST['password'];

        $validation = $this->model->validateLogin($username, $pass);

        if ($validation != null) {
            $_SESSION['username'] = $username;
            $_SESSION['imagen'] = $validation['imagen'];
        }

        header('location: /Monquiz/app/lobby/mostrarLobby');
        exit();
    }

    public function login(){
        $data = [];
        if (isset($_SESSION['username'])) {
            $data['username'] = $_SESSION['username'];
        }
        $this->presenter->show("login",$data);
    }

    public function register(){
        $data = [];
        if (isset($_SESSION['username'])) {
            $data['username'] = $_SESSION['username'];
        }
        $this->presenter->show("register",$data);
    }

    public function logout(){
        session_unset();
        session_destroy();
        header('Location: /Monquiz/app/usuario/login');
        exit();
    }

    public function validar(){
        $id = $_GET['id'] ?? null;
        $token = $_GET['token'] ?? null;

        if ($id != null && $token != null ) {
            $this->model->validarToken($id, $token);
        } else {
            echo "Faltan parámetros para la validación.";
            echo $id;
            echo $token;
        }

    }

    public function validatePassword($pass, $pass2): bool
    {
        return $pass == $pass2;
    }


}