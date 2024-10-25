<?php

class JuegoController{

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

        $imagenUser = $_SESSION['imagen'];
        $nombreUsuarioSesion = $_SESSION['username'];

        $data = [
            'imagen' => $imagenUser,
            'user' => $nombreUsuarioSesion
        ];

        $this->presenter->show('ruleta', $data);
    }

    public function mostrarPregunta()
    {

        $imagenUser = $_SESSION['imagen'];
        $nombreUsuarioSesion = $_SESSION['username'];


        $resultado_ruleta = $_SESSION['resultado_ruleta'];

        $categoria = $this->model->traerCategoria($resultado_ruleta);

        if ($categoria) {
            $data = [
                'imagen' => $imagenUser,
                'user' => $nombreUsuarioSesion,
                'resultado_ruleta' => $_SESSION['resultado_ruleta'],
                'descripcion' => $categoria['descripcion'],
                'color' => $categoria['color']
            ];

            $this->presenter->show('pregunta', $data);
        } else {
            echo "Categoría no encontrada";
        }
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