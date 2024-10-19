<?php

class PerfilController{

    //Haciendo click en esos jugadores, tengo que poder ver el perfil de ese jugador con sus datos (mapa
    //incluido), con su nombre, puntaje final y partidas realizadas, y un QR para navegar rápidamente a
    //su perfil.

    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function mostrarPerfil() {
        if (!isset($_SESSION['user'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $user = $_SESSION['user'];
        $datosPerfil = $this->model->getPerfil($user);

        if (empty($datosPerfil)) {
            echo "No se encontraron datos para el usuario.";
            exit();
        }

        $perfil = $datosPerfil[0];

        $this->presenter->show('perfil', $perfil);
    }



}
