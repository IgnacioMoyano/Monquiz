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
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['tipo_cuenta'] == 1) {
            header('Location: /Monquiz/app/editor/verPreguntas');
            exit();
        }
        if ($_SESSION['tipo_cuenta'] == 2) {
            header('Location: /Monquiz/app/administrador/verGraficosAno');
            exit();
        }

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

        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['tipo_cuenta'] == 1) {
            header('Location: /Monquiz/app/editor/verPreguntas');
            exit();
        }
        if ($_SESSION['tipo_cuenta'] == 2) {
            header('Location: /Monquiz/app/administrador/verGraficosAno');
            exit();
        }

        $categorias = $this->model->getCategorias();

        $data = [
            "categorias" => $categorias,
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        $this->presenter->show('sugerirPregunta', $data);
    }

    public function enviarSugerencia(){
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['tipo_cuenta'] == 1) {
            header('Location: /Monquiz/app/editor/verPreguntas');
            exit();
        }
        if ($_SESSION['tipo_cuenta'] == 2) {
            header('Location: /Monquiz/app/administrador/verGraficosAno');
            exit();
        }
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
