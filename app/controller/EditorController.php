<?php


class EditorController
{

    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function home(){

        $this->presenter->show('editorHome');
    }

    public function verPreguntas(){

        $data = $this->model->getAllPreguntas();

        $this->presenter->show('verPreguntas', ['data' => $data]);
    }

    public function verPreguntasReportadas(){

        $data = $this->model->getPreguntasReportadas();

        $this->presenter->show('verPreguntas', ['data' => $data]);
    }

    public function verPreguntasPendientes(){

        $data = $this->model->getPreguntasPendientes();

        $this->presenter->show('verPreguntas', ['data' => $data]);
    }

    public function editarPregunta(){

        $idPregunta = isset($_GET['id']) ? $_GET['id'] : '';

        $pregunta = $this->model->getPregunta($idPregunta);

        $respuestas = $this->model->getRespuestas($idPregunta);

        $data = [
            'pregunta' => $pregunta,
            'respuestas' => $respuestas
        ];

        $this->presenter->show('editarPregunta', $data);
    }

    public function modificarPregunta()
    {
        $datosPregunta = [
            'id' => $_POST['id'],
            'pregunta' => $_POST['pregunta'],
            'categoria_FK' => $_POST['categoria_FK'],
            'estado_FK' => $_POST['estado_FK'],
            'reportada' => $_POST['reportada'],
            'cantidad_vista' => $_POST['cantidad_vista'],
            'cantidad_correctas' => $_POST['cantidad_correctas'],
            'creada_usuarios' => $_POST['creada_usuarios'],
            'respuestas' => isset($_POST['respuestas']) ? $_POST['respuestas'] : [],
            'respuesta_correcta' => isset($_POST['respuesta_correcta']) ? $_POST['respuesta_correcta'] : null
        ];


        $resultado = $this->model->actualizarPregunta($datosPregunta);

        if ($resultado) {

            header("Location: /MONQUIZ/app/editor/verPreguntas");
            exit();
        } else {

            echo "Error al actualizar la pregunta. Detalles del error: ";
        }
    }

    public function verCrearPregunta()
    {
        $categorias = $this->model->getCategorias();

        $data = [
            "categorias" => $categorias,
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        $this->presenter->show('editorCrearPregunta', $data);
    }

    public function enviarPregunta(){
        $pregunta = $_POST['pregunta'] ?? null;
        $respuesta_correcta = $_POST['respuesta_correcta'] ?? null;
        $respuesta_incorrecta1 = $_POST['respuesta_incorrecta1'] ?? null;
        $respuesta_incorrecta2 = $_POST['respuesta_incorrecta2'] ?? null;
        $respuesta_incorrecta3 = $_POST['respuesta_incorrecta3'] ?? null;
        $categoria = $_POST['categoria'] ?? null;

        if (empty($pregunta) || empty($respuesta_correcta) || empty($respuesta_incorrecta1) || empty($respuesta_incorrecta2) || empty($respuesta_incorrecta3) || empty($categoria)) {
            echo "Debes llenar todos los campos.";
        }

        $resultado = $this->model->crearPregunta($pregunta, $categoria, $respuesta_correcta, $respuesta_incorrecta1, $respuesta_incorrecta2, $respuesta_incorrecta3);

        $data = [
            "categorias" => $this->model->getCategorias(),
        ];

        $this->presenter->show("editorCrearPregunta", $data);
    }



}