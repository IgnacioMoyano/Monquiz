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
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $userLogueado = $_SESSION['username'];
        $datosUsuarioLogueado = $this->model->getPerfil($userLogueado);


        if (isset($_GET['username'])) {
            $usernamePerfil = $_GET['username'];
        } else {
            $usernamePerfil = $userLogueado;
        }

        $datosPerfil = $this->model->getPerfil($usernamePerfil);

        if (empty($datosPerfil)) {
            echo "No se encontraron datos para el usuario.";
            exit();
        }

        $perfil = $datosPerfil[0];


        $data = [
            'user' => $userLogueado,
            'perfil' => $perfil,
            'imagenUsuarioLogueado' => $datosUsuarioLogueado[0]['imagen']
        ];

        $this->presenter->show('perfil', $data);
    }
}