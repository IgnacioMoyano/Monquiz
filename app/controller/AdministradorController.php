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
        /*
            if (!isset($_SESSION['username'])) {
                header('Location: /Monquiz/app/usuario/login');
                exit();
            }
            if ($_SESSION['validado'] !=  1) {
                header('Location: /Monquiz/app/usuario/login');
                exit();
            }
        */

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
        $edad = $_GET['edad'];
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username='nico';

        echo "El año de nacimiento es: $anioNacimiento";

        $usuariosUltimoAno = $this->model->obtenerCantidadUsuarios($fechaUltimoAno, $fechaActual);
        $partidasUltimoAno = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimoAno, $fechaActual);
        $preguntasUltimoAno = $this->model->verCantidadPreguntasPorFecha($fechaUltimoAno, $fechaActual);
        $preguntasCreadasUsuarioUltimoAno = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimoAno, $fechaActual);


        $porcentajeRespuestasCorrectasPorUltimoAno= $this->model->porcentajeRespuestasCorrectasPorFecha($fechaUltimoAno, $fechaActual,$username);
echo $porcentajeRespuestasCorrectasPorUltimoAno[0][0];

        $data = [
            'usuariosCreados' => $usuariosUltimoAno,
            'partidasCreadas' => $partidasUltimoAno,
            'preguntasCreadas' => $preguntasUltimoAno,
            'preguntasCreadasUsuario' => $preguntasCreadasUsuarioUltimoAno
        ];

        $this->presenter->show("administrador", $data);
    }

    public function verGraficosMes()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimoMes = date('Y-m-d H:i:s', strtotime('-1 month'));
        $partidasUltimoMes = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimoMes, $fechaActual);
        $usuariosUltimoMes = $this->model->obtenerCantidadUsuarios($fechaUltimoMes, $fechaActual);
        $preguntasUltimoMes = $this->model->verCantidadPreguntasPorFecha($fechaUltimoMes, $fechaActual);
        $preguntasCreadasUsuarioUltimoMes = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimoMes, $fechaActual);

        $data = [
            'usuariosCreados' => $usuariosUltimoMes,
            'partidasCreadas' => $partidasUltimoMes,
            'preguntasCreadas' => $preguntasUltimoMes,
            'preguntasCreadasUsuario' => $preguntasCreadasUsuarioUltimoMes
        ];

        $this->presenter->show("administrador", $data);
    }

    public function verGraficosSemana()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimaSemana = date('Y-m-d H:i:s', strtotime('-1 week'));

        $usuariosUltimaSemana = $this->model->obtenerCantidadUsuarios($fechaUltimaSemana, $fechaActual);
        $partidasUltimaSemana = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimaSemana, $fechaActual);
        $preguntasUltimaSemana = $this->model->verCantidadPreguntasPorFecha($fechaUltimaSemana, $fechaActual);
        $preguntasCreadasUsuarioUltimaSemana = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimaSemana, $fechaActual);


        $data = [
            'usuariosCreados' => $usuariosUltimaSemana,
            'partidasCreadas' => $partidasUltimaSemana,
            'preguntasCreadas' => $preguntasUltimaSemana,
            'preguntasCreadasUsuario' => $preguntasCreadasUsuarioUltimaSemana
        ];

        $this->presenter->show("administrador", $data);
    }

    public function verGraficosDia()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimoDia = date('Y-m-d H:i:s', strtotime('-1 day'));

        $partidasUltimoDia = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimoDia, $fechaActual);
        $usuariosUltimoDia = $this->model->obtenerCantidadUsuarios($fechaUltimoDia, $fechaActual);
        $preguntasUltimoDia = $this->model->verCantidadPreguntasPorFecha($fechaUltimoDia, $fechaActual);
        $preguntasCreadasUsuarioUltimoDia = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimoDia, $fechaActual);


        $data = [
            'usuariosCreados' => $usuariosUltimoDia,
            'partidasCreadas' => $partidasUltimoDia,
            'preguntasCreadas' => $preguntasUltimoDia,
            'preguntasCreadasUsuario' => $preguntasCreadasUsuarioUltimoDia
        ];

        $this->presenter->show("administrador", $data);
    }


}
