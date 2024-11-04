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

        $idUser = $_SESSION['id'];

       $puntaje = $this->model->getPuntajeMaximo($idUser);
        $data = [
            'puntaje' => $puntaje,
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];




        $this->presenter->show('lobby', $data);
    }

}
