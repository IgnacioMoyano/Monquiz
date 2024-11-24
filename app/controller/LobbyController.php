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

    public function mostrarSugerencia()
    {

        $categorias = $this->model->getCategorias();

        $data = [
            "categorias" => $categorias,
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        $this->presenter->show('sugerirPregunta', $data);
    }

    public function enviarSugerencia(){

        $pregunta = $_POST['pregunta'];
        $respuesta_correcta = $_POST['respuesta_correcta'];
        $respuesta_incorrecta1 = $_POST['respuesta_incorrecta1'];
        $respuesta_incorrecta2 = $_POST['respuesta_incorrecta2'];
        $respuesta_incorrecta3 = $_POST['respuesta_incorrecta3'];
        $categoria = $_POST['categoria'];

        if (empty($pregunta) || empty($respuesta_correcta) || empty($respuesta_incorrecta1) || empty($respuesta_incorrecta2) || empty($respuesta_incorrecta3) || empty($categoria)) {
            echo "Debes llenar todos los campos.";
        }

        $resultado = $this->model->guardarSugerencia($pregunta, $categoria, $respuesta_correcta, $respuesta_incorrecta1, $respuesta_incorrecta2, $respuesta_incorrecta3);

        $data = [
            "categorias" => $this->model->getCategorias(),


        ];

        $this->presenter->show("sugerirPregunta", $data);
    }

}
