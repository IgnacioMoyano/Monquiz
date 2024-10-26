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

       // $puntaje = $this->model->getPuntajeMaximo(1)
        $data = [
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];


        $this->presenter->show('lobby', $data);
    }

}
