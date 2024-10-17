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
        // datos hardcodeados hasta tener una base de datos
        $datosPerfil = [
            'nombre' => 'Luis Alberto',
            'edad' => 28,
            'descripcion' => 'Experto en monos.',
        ];

        $this->presenter->show('perfil', $datosPerfil);
    }


}
