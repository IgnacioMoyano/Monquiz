<?php


class EditorController
{

    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
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

}