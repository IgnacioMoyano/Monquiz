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

        $this->presenter->show('lobby');
    }

}
