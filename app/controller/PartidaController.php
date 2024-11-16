<?php

class PartidaController{

    private $presenter;
    private $model;
    public function __construct($model, $presenter){
        $this->presenter = $presenter;
        $this->model = $model;
    }

    public function crearPartida(){
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }



        $this->model->crearPartida($_SESSION['id']);


        $this->jugar();
    }

    public function jugar()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $data = [
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        $idRespuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;

        if(isset($idRespuesta) || $idRespuesta != null){
            $this->validarRespuesta($idRespuesta);
        }


        $this->presenter->show('ruleta', $data);
    }

    public function mostrarPregunta() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        $resultado_ruleta = $_SESSION['resultado_ruleta'];
        $userId = $_SESSION['id'];

        $dataModel = $this->model->traerPregunta($resultado_ruleta, $userId);
        $pregunta = $dataModel[0];
        $tiempoEntrega = $dataModel[1];

        if (!isset($_SESSION['pregunta_id']) && !isset($_SESSION['tiempo_entrega'])) {
            $_SESSION['pregunta_id'] = $pregunta['id'];
            $_SESSION['tiempo_entrega'] = $tiempoEntrega;
        }

        if (!$pregunta) {
            echo "Pregunta no encontrada.";
            return;
        }

        $dificultad = $this->model->calcularDificultadPregunta($pregunta['id']);

        $respuestas = $this->model->traerRespuesta($pregunta['id']);
        if ($respuestas === null) {
            echo "No se encontraron respuestas.";
            return;
        } else {
            shuffle($respuestas);
        }

        $categoria = $this->model->traerCategoria($resultado_ruleta);
        if (!$categoria) {
            echo "Categoría no encontrada.";
            return;
        }


        $data = [
            'resultado_ruleta' => $_SESSION['resultado_ruleta'],
            'descripcion' => $categoria['descripcion'],
            'color' => $categoria['color'],
            'pregunta' => $pregunta['pregunta'],
            'preguntaId' => $pregunta['id'],
            'respuestas' => $respuestas,
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen'],
            'tiempoEntrega' => $tiempoEntrega,
            'dificultad' => $dificultad

        ];

        $this->presenter->show('pregunta', $data);
    }

    public function resultado() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);


        if (isset($data['valor'])) {
            $valor = $data['valor'];

            $_SESSION['resultado_ruleta'] = $valor;

            echo json_encode([
                'status' => 'success',
                'mensaje' => 'Valor recibido correctamente',
                'valor' => $valor
            ]);

        } else {

            echo json_encode([
                'status' => 'error',
                'mensaje' => 'No se recibió ningún valor'
            ]);
        }


    }

    public function validarRespuesta($idRespuesta)
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        if (!$this->model->validarTiempoRespuesta($_SESSION['pregunta_id'])) {
            $id = $_SESSION['id'];

            $this->model->finalizarPartida($id);
            header(
                'Location: /Monquiz/app/lobby/mostrarLobby'
            ); exit();
        }

        $respuestaCorrecta = $this->model->respuestaCorrecta($idRespuesta);

        if ($respuestaCorrecta && isset($respuestaCorrecta['id']) && $idRespuesta == $respuestaCorrecta['id']) {

            $id = $_SESSION['id'];
            unset($_SESSION['pregunta_id']);
            unset($_SESSION['tiempo_entrega']);
          $this->model->sumarPuntuacion($id);

        } else {

            $id = $_SESSION['id'];

            $this->model->finalizarPartida($id);
            header(
                'Location: /Monquiz/app/lobby/mostrarLobby'
            ); exit();


        }
    }

    public function reportar()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

       $idPreguntaReportada = isset($_POST['preguntaId']) ? $_POST['preguntaId'] : null;
        $pregunta = isset($_POST['pregunta']) ? $_POST['pregunta'] : null;
        $respuestas = isset($_POST['respuestas']) ? $_POST['respuestas'] : [];


        $data = [
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen'],
            'preguntaReportada' => $idPreguntaReportada,
            'pregunta' => $pregunta,
            'respuestas' => $respuestas
        ];
       $this->presenter->show('reportar', $data);
    }

    public function enviarReporte(){
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $idPreguntaReportada = isset($_POST['preguntaReportada']) ? $_POST['preguntaReportada'] : null;
        $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
        $idUser = $_SESSION['id'];

        $puntuacion = $_SESSION['puntuacion'];
        $username = $_SESSION['username'];

        $this->model->enviarReporte($idPreguntaReportada, $descripcion, $idUser);
        $this->model->finalizarPartida($puntuacion, $username);
        header(
            'Location: /Monquiz/app/lobby/mostrarLobby'
        ); exit();
    }

    public function timeOut() {
        $userId = $_SESSION['id'] ?? null;
        if ($userId) {
            $this->model->finalizarPartida($userId);
        }
        header('Location: /Monquiz/app/lobby/mostrarLobby');
        exit();
    }
}