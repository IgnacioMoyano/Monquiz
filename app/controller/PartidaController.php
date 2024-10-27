<?php

class PartidaController{

    private $presenter;
    private $model;
    public function __construct($model, $presenter){
        $this->presenter = $presenter;
        $this->model = $model;
    }

    public function mostrar()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $_SESSION['puntuacion'] = 0;

      $this->model->crearPartida($_SESSION['username']);

        $this->presenter->show('ruleta');
    }

    public function mostrarPregunta() {
        $resultado_ruleta = $_SESSION['resultado_ruleta'];


        $pregunta = $this->model->traerPregunta($resultado_ruleta);
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
            'respuestas' => $respuestas
        ];

        // Muestra la vista con los datos
        $this->presenter->show('pregunta', $data);
    }

    public function resultado() {
        if (!isset($_SESSION['username'])) {
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

    public function validarRespuesta()
    {
        $idRespuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;
        
        $respuestaCorrecta = $this->model->respuestaCorrecta($idRespuesta);

        if ($respuestaCorrecta && isset($respuestaCorrecta['id']) && $idRespuesta == $respuestaCorrecta['id']) {
            $puntuacion = $_SESSION['puntuacion'];

            $_SESSION['puntuacion'] = $this->model->sumarPuntuacion($puntuacion);
            $this->presenter->show('ruleta');
        } else {
            $puntuacion = $_SESSION['puntuacion'];
            $username = $_SESSION['username'];

            $this->model->finalizarPartida($puntuacion, $username);
            header(
                'Location: /Monquiz/app/lobby/mostrarLobby'
            ); exit();


        }
    }
}