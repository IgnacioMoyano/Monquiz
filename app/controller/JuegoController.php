<?php

class JuegoController{

    private $presenter;
    public function __construct($presenter){
        $this->presenter = $presenter;
    }

    public function mostrar()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        $this->presenter->show('ruleta');
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

}