<?php

class LobbyController{

    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function mostrarLobby(){
        if (!isset($_SESSION['userId'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }



        $userId = $_SESSION['userId']; // Recuperar el userId de la sesión

        echo "User ID: " . $userId;

        $puntaje = $this->model->getPuntajeMaximo($userId); // Llamar a getPuntajeMaximo con el userId

        // Asegúrate de que puntaje es un valor único
        $this->presenter->show('lobby', ['puntaje' => $puntaje]);
    }

}
