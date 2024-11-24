<?php

class PartidaController{

    private $presenter;
    private $model;
    public function __construct($model, $presenter){
        $this->presenter = $presenter;
        $this->model = $model;
    }

    public function crearPartida(){
        $this->model->crearPartida($_SESSION['id']);


        $this->jugar();
    }

    public function jugar()
    {

        $data = [
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        $idRespuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;
        $idPregunta = isset($_POST['pregunta_id']) ? $_POST['pregunta_id'] : null;


        if (isset($idRespuesta) && $idRespuesta != null && isset($idPregunta) && $idPregunta != null) {
            $this->validarRespuesta($idRespuesta, $idPregunta);
        }


        $this->presenter->show('ruleta', $data);
    }

    public function mostrarPregunta() {

        $resultado_ruleta = $_SESSION['resultado_ruleta'];

        $userId = $_SESSION['id'];

        $dataModel = $this->model->traerPregunta($resultado_ruleta,$userId);
        $pregunta = $dataModel;
        $tiempoEntrega = time();

        if (!isset($_SESSION['pregunta_id'])) {
            $_SESSION['pregunta_id'] = $pregunta['id'];
        }
            $_SESSION['tiempo_entrega'] = $tiempoEntrega;


        if (!$pregunta) {
            echo "Pregunta no encontrada.";
            return;
        }

        $respuestas = $this->model->traerRespuesta($pregunta['id']);
        if ($respuestas === null) {
            echo "No se encontraron respuestas.";
            return;
        } else{
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
            'tiempoEntrega' => $tiempoEntrega
        ];


        $this->presenter->show('pregunta', $data);
    }

    public function resultado() {


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

    public function validarRespuesta($idRespuesta, $idPregunta)
    {
        if ($_SESSION['pregunta_id'] != $idPregunta) {

            $id = $_SESSION['id'];
            unset($_SESSION['pregunta_id']);
            unset($_SESSION['tiempo_entrega']);
            $this->model->finalizarPartida($id);
            header('Location: /Monquiz/app/lobby/mostrarLobby');
            exit();
        }


        if (!$this->model->validarTiempoRespuesta($_SESSION['pregunta_id'])) {
            $id = $_SESSION['id'];
            $this->model->finalizarPartida($id);
            header('Location: /Monquiz/app/lobby/mostrarLobby');
            exit();
        }


        $respuestaCorrecta = $this->model->respuestaCorrecta($idRespuesta);

        if ($respuestaCorrecta && isset($respuestaCorrecta['id']) && $idRespuesta == $respuestaCorrecta['id']) {
            $id = $_SESSION['id'];
            unset($_SESSION['pregunta_id']);
            unset($_SESSION['tiempo_entrega']);

            $this->model->sumarPuntuacion($id);
        } else {

            $id = $_SESSION['id'];
            unset($_SESSION['pregunta_id']);
            unset($_SESSION['tiempo_entrega']);
            $this->model->finalizarPartida($id);
            header('Location: /Monquiz/app/partida/perdiste');
            exit();
        }
    }

    public function perdiste()
    {

        $this->presenter->show('perdiste');

    }

    public function reportar()
    {
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