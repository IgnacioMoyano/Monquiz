<?php

class AdministradorController
{
    private $model;

    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }


    public function mostrarAdministrador()
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


        $cantidadJugadores = $this->model->verCantidadJugadores();
        $cantidadPartidasJugadas = $this->model->verCantidadPartidasJugadas();
        $verCantidadPreguntas = $this->model->verCantidadPreguntas();
        $verCantidadDePreguntasCreadas = $this->model->verCantidadDePreguntasCreadas();

        $verCantidadDeUsuariosNuevos = $this->verCantidadDeUsuariosNuevos();

        $porcentajeRespuestasCorrectas = $this->model->verPorcentajeRespuestasCorrectas();
        $verCantidadUsuariosPorPais = $this->model->verCantidadUsuariosPorPais();
        $verCantidadUsuariosPorSexo = $this->model->verCantidadUsuariosPorSexo();


        $data = [
            'cantidadJugadores' => $cantidadJugadores,
            'cantidadPartidasJugadas' => $cantidadPartidasJugadas,
            'verCantidadPreguntas' => $verCantidadPreguntas,
            'verCantidadDePreguntasCreadas' => $verCantidadDePreguntasCreadas,
            'verCantidadDeUsuariosNuevos' => $verCantidadDeUsuariosNuevos,
            'porcentajeRespuestasCorrectas' => $porcentajeRespuestasCorrectas,
            'verCantidadUsuariosPorPais' => $verCantidadUsuariosPorPais,
            'verCantidadUsuariosPorSexo' => $verCantidadUsuariosPorSexo


        ];

        $this->presenter->show("administrador", $data);
    }

    public function verGraficosAno()
    {


        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimoAno = date('Y-m-d H:i:s', strtotime('-1 year'));
        $edad = isset($_GET['edad']) ? $_GET['edad'] : null;
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=isset($_GET['username']) ? $_GET['username'] : null;;
        $pais=isset($_GET['pais']) ? $_GET['pais'] : null;;
        $sexo=isset($_GET['sexo']) ? $_GET['sexo'] : null;;

        $cantidadJugadores = $this->model->verCantidadJugadores();


        $usuariosUltimoAno = $this->model->obtenerCantidadUsuarios($fechaUltimoAno, $fechaActual);
        $partidasUltimoAno = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimoAno, $fechaActual);
        $preguntasUltimoAno = $this->model->verCantidadPreguntasPorFecha($fechaUltimoAno, $fechaActual);
        $preguntasCreadasUsuarioUltimoAno = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimoAno, $fechaActual);
        $porcentajeRespuestasCorrectasPorUltimoAno= $this->model->porcentajeRespuestasCorrectasPorFecha($fechaUltimoAno, $fechaActual,$username);
        $cantidadUsuariosPorPaisUltimoAno= $this->model->verCantidadUsuariosPorPaisYFecha($fechaUltimoAno, $fechaActual, $pais);
        $cantidadUsuariosPorSexoUltimoAno=$this->model->verCantidadUsuariosPorSexoYFecha($fechaUltimoAno, $fechaActual, $sexo);
        $cantidadUsuariosPorEdadUltimoAno=$this->model->verCantidadUsuariosPorEdadYFecha($fechaUltimoAno, $fechaActual);






        $data = [
            'graficoUsuarios' => [
                ['Categoría', 'Cantidad'], // Encabezados para Google Charts
                ['Usuarios Creados', (int)$usuariosUltimoAno],
                ['Partidas Creadas', (int)$partidasUltimoAno],
                ['Preguntas Creadas', (int)$preguntasUltimoAno],
            ],
            'cantidadJugadores' => (int)$cantidadJugadores,

            'preguntasCreadasUsuario' => (int)$preguntasCreadasUsuarioUltimoAno,
            'porcentajeRespuestasCorrectas' => (int)$porcentajeRespuestasCorrectasPorUltimoAno,
            'cantidadUsuariosPorPais' => (int)$cantidadUsuariosPorPaisUltimoAno,
            'cantidadUsuariosPorSexo' => (int)$cantidadUsuariosPorSexoUltimoAno,
            'cantidadUsuariosPorEdad' => (int)$cantidadUsuariosPorEdadUltimoAno,

        ];



        $this->presenter->show("administrador", [
            'data' => json_encode($data), // Convertir a JSON para enviarlo a la vista
        ]);
    }

    public function verGraficosMes()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimoMes = date('Y-m-d H:i:s', strtotime('-1 month'));

        $edad = $_GET['edad'];
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=$_GET['username'];
        $pais=$_GET['pais'];
        $sexo=$_GET['sexo'];


        $partidasUltimoMes = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimoMes, $fechaActual);
        $usuariosUltimoMes = $this->model->obtenerCantidadUsuarios($fechaUltimoMes, $fechaActual);
        $preguntasUltimoMes = $this->model->verCantidadPreguntasPorFecha($fechaUltimoMes, $fechaActual);
        $preguntasCreadasUsuarioUltimoMes = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimoMes, $fechaActual);
        $porcentajeRespuestasCorrectasPorUltimoMes= $this->model->porcentajeRespuestasCorrectasPorFecha($fechaUltimoMes, $fechaActual,$username);
        $cantidadUsuariosPorPaisUltimoMes= $this->model->verCantidadUsuariosPorPaisYFecha($fechaUltimoMes, $fechaActual, $pais);
        $cantidadUsuariosPorSexoUltimoMes=$this->model->verCantidadUsuariosPorSexoYFecha($fechaUltimoMes, $fechaActual, $sexo);
        $cantidadUsuariosPorEdadUltimoMes=$this->model->verCantidadUsuariosPorEdadYFecha($fechaUltimoMes, $fechaActual, $edad);

        $data = [
            'usuariosCreados' => $usuariosUltimoMes,
            'partidasCreadas' => $partidasUltimoMes,
            'preguntasCreadas' => $preguntasUltimoMes,
            'preguntasCreadasUsuario' => $preguntasCreadasUsuarioUltimoMes,
            'porcentajeRespuestasCorrectas' => $porcentajeRespuestasCorrectasPorUltimoMes,
            'cantidadUsuariosPorPais' => $cantidadUsuariosPorPaisUltimoMes,
            'cantidadUsuariosPorSexo' => $cantidadUsuariosPorSexoUltimoMes,
            'cantidadUsuariosPorEdad' => $cantidadUsuariosPorEdadUltimoMes,
        ];

        echo json_encode($data);

        $this->presenter->show("administrador", $data);
    }

    public function verGraficosSemana()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimaSemana = date('Y-m-d H:i:s', strtotime('-1 week'));

        $edad = $_GET['edad'];
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=$_GET['username'];
        $pais=$_GET['pais'];
        $sexo=$_GET['sexo'];

        $usuariosUltimaSemana = $this->model->obtenerCantidadUsuarios($fechaUltimaSemana, $fechaActual);
        $partidasUltimaSemana = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimaSemana, $fechaActual);
        $preguntasUltimaSemana = $this->model->verCantidadPreguntasPorFecha($fechaUltimaSemana, $fechaActual);
        $preguntasCreadasUsuarioUltimaSemana = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimaSemana, $fechaActual);
        $porcentajeRespuestasCorrectasPorUltimaSemana= $this->model->porcentajeRespuestasCorrectasPorFecha($fechaUltimaSemana, $fechaActual,$username);
        $cantidadUsuariosPorPaisUltimaSemana= $this->model->verCantidadUsuariosPorPaisYFecha($fechaUltimaSemana, $fechaActual, $pais);
        $cantidadUsuariosPorSexoUltimaSemana=$this->model->verCantidadUsuariosPorSexoYFecha($fechaUltimaSemana, $fechaActual, $sexo);
        $cantidadUsuariosPorEdadUltimaSemana=$this->model->verCantidadUsuariosPorEdadYFecha($fechaUltimaSemana, $fechaActual, $edad);


        $data = [
            'usuariosCreados' => $usuariosUltimaSemana,
            'partidasCreadas' => $partidasUltimaSemana,
            'preguntasCreadas' => $preguntasUltimaSemana,
            'preguntasCreadasUsuario' => $preguntasCreadasUsuarioUltimaSemana,
            'porcentajeRespuestasCorrectas' => $porcentajeRespuestasCorrectasPorUltimaSemana,
            'cantidadUsuariosPorPais' => $cantidadUsuariosPorPaisUltimaSemana,
            'cantidadUsuariosPorSexo' => $cantidadUsuariosPorSexoUltimaSemana,
            'cantidadUsuariosPorEdad' => $cantidadUsuariosPorEdadUltimaSemana,
        ];



        $this->presenter->show("administrador", $data);
    }

    public function verGraficosDia()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimoDia = date('Y-m-d H:i:s', strtotime('-1 day'));

        $edad = $_GET['edad'];
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=$_GET['username'];
        $pais=$_GET['pais'];
        $sexo=$_GET['sexo'];

        $partidasUltimoDia = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimoDia, $fechaActual);
        $usuariosUltimoDia = $this->model->obtenerCantidadUsuarios($fechaUltimoDia, $fechaActual);
        $preguntasUltimoDia = $this->model->verCantidadPreguntasPorFecha($fechaUltimoDia, $fechaActual);
        $preguntasCreadasUsuarioUltimoDia = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimoDia, $fechaActual);
        $porcentajeRespuestasCorrectasPorUltimoDia= $this->model->porcentajeRespuestasCorrectasPorFecha($fechaUltimoDia, $fechaActual,$username);
        $cantidadUsuariosPorPaisUltimoDia= $this->model->verCantidadUsuariosPorPaisYFecha($fechaUltimoDia, $fechaActual, $pais);
        $cantidadUsuariosPorSexoUltimoDia=$this->model->verCantidadUsuariosPorSexoYFecha($fechaUltimoDia, $fechaActual, $sexo);
        $cantidadUsuariosPorEdadUltimoDia=$this->model->verCantidadUsuariosPorEdadYFecha($fechaUltimoDia, $fechaActual, $edad);


        $data = [
            'usuariosCreados' => $usuariosUltimoDia,
            'partidasCreadas' => $partidasUltimoDia,
            'preguntasCreadas' => $preguntasUltimoDia,
            'preguntasCreadasUsuario' => $preguntasCreadasUsuarioUltimoDia,
            'porcentajeRespuestasCorrectas' => $porcentajeRespuestasCorrectasPorUltimoDia,
            'cantidadUsuariosPorPais' => $cantidadUsuariosPorPaisUltimoDia,
            'cantidadUsuariosPorSexo' => $cantidadUsuariosPorSexoUltimoDia,
            'cantidadUsuariosPorEdad' => $cantidadUsuariosPorEdadUltimoDia,
        ];

        $this->presenter->show("administrador", $data);
    }


}
