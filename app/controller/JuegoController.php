<?php

class JuegoController{

    private $presenter;
    public function __construct($presenter){
        $this->presenter = $presenter;
    }

    public function mostrar()
    {
        $this->presenter->show('ruleta');
    }

    public function mostrarPregunta()
    {
        $this->presenter->show('pregunta');
    }

    public function resultado() {

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);


        if (isset($data['valor'])) {
            $valor = $data['valor'];

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
        $valorRespuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;

        if ($valorRespuesta != null && $valorRespuesta == 'lionel') {
        echo json_encode([
            'status' => 'success',
            'mensaje' => 'Respuesta correcta'
        ]);
        } else {
        echo json_encode([
            'status' => 'error',
            'mensaje' => 'Respuesta incorrecta'
        ]);
        }
    }
}