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

    public function verGraficos()
    {


        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimo = date('Y-m-d H:i:s', strtotime('-1 year'));
        $edad = isset($_GET['edad']) ? $_GET['edad'] : null;
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=isset($_GET['username']) ? $_GET['username'] : null;;
        $pais=isset($_GET['pais']) ? $_GET['pais'] : null;;
        $sexo=isset($_GET['sexo']) ? $_GET['sexo'] : null;;

        $cantidadJugadores = $this->model->verCantidadJugadores();
        $cantidadPartidasJugadas = $this->model->verCantidadPartidasJugadas();

        $usuariosUltimoAno = $this->model->obtenerCantidadUsuarios($fechaUltimo, $fechaActual);
        $partidasUltimoAno = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);
        $preguntasUltimoAno = $this->model->verCantidadPreguntasPorFecha($fechaUltimo, $fechaActual);
        $preguntasCreadasUsuarioUltimoAno = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimo, $fechaActual);




        $puntuacionTotal = $this->model->verPuntuacionTotal($fechaUltimo, $fechaActual);
        $totalPartidas = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);

        $totalPreguntasVistas = $puntuacionTotal + $totalPartidas;

        if($puntuacionTotal == 0) {
            $porcentajeRespuestasCorrectas = 0;
        } else {
            $porcentajeRespuestasCorrectas =  ($puntuacionTotal * 100) / $totalPreguntasVistas;
        }
        $totalRespuestasIncorrectas = 100 - $porcentajeRespuestasCorrectas;

        $edadJovenes = $this->model->verCantidadUsuariosJovenesYFecha($fechaUltimo, $fechaActual);
        $edadMedio = $this->model->verCantidadUsuariosMediosYFecha($fechaUltimo, $fechaActual);
        $edadAdultos = $this->model->verCantidadUsuariosJubiladosYFecha($fechaUltimo, $fechaActual);



        //Usuario pais

        $hombre = $this->model->verCantidadUsuariosPorSexoHombre($fechaUltimo, $fechaActual);
        $mujer = $this->model->verCantidadUsuariosPorSexoMujer($fechaUltimo, $fechaActual);
        $otro = $this->model->verCantidadUsuariosPorSexoOtro($fechaUltimo, $fechaActual);

        $paises = $this->model->verCantidadUsuariosPais($fechaUltimo, $fechaActual);




        $data = [
            'graficoPreguntas' => [
                ['Categoría', 'Cantidad'],
                ['Preguntas Creadas', (int)$preguntasUltimoAno],
                ['Preguntas por Usuario', (int)$preguntasCreadasUsuarioUltimoAno],
            ],

            'graficoJugadores' => [
                ['Categoría', 'Cantidad'],
                ['Jugadores Totales', (int)$cantidadJugadores],
                ['Usuarios Creados', (int)$usuariosUltimoAno]
            ],

            'graficoPartidas' => [
                ['Categoría', 'Cantidad'],
                ['Partidas Totales', (int)$cantidadPartidasJugadas],
                ['Partidas jugadas', (int)$partidasUltimoAno]
            ],

            'graficoEdad' => [
                ['Categoría', 'Cantidad'],
                ['Usuarios jovenes', (int)$edadJovenes],
                ['Usuarios adultos', (int)$edadMedio],
                ['Usuarios ancianos', (int)$edadAdultos]
            ],

            'graficoPorcentaje' => [
                ['Categoría', 'Cantidad'],
                ['Respuestas Incorrectas', $totalRespuestasIncorrectas],
                ['Respuestas Correctas', $porcentajeRespuestasCorrectas]
            ],
            'graficoGenero' => [
                ['Categoría', 'Cantidad'],
                ['Hombres', (int)$hombre],
                ['Mujeres', (int)$mujer],
                ['Otro', (int)$otro],
            ],
            'graficoPais' => [
                ['Categoría', 'Cantidad']
            ],

        ];

        foreach ($paises as $row) {
            $data['graficoPais'][] = [
                (string) $row['pais'],
                (int)$row['total_usuarios_pais']
            ];
        }

        $this->presenter->show("administrador", [
            'data' => json_encode($data), // Convertir a JSON para enviarlo a la vista
        ]);
    }

    public function verGraficosMes()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimo = date('Y-m-d H:i:s', strtotime('-1 month'));

        $edad = isset($_GET['edad']) ? $_GET['edad'] : null;
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=isset($_GET['username']) ? $_GET['username'] : null;;
        $pais=isset($_GET['pais']) ? $_GET['pais'] : null;;
        $sexo=isset($_GET['sexo']) ? $_GET['sexo'] : null;;

        $cantidadJugadores = $this->model->verCantidadJugadores();
        $cantidadPartidasJugadas = $this->model->verCantidadPartidasJugadas();

        $usuariosUltimo = $this->model->obtenerCantidadUsuarios($fechaUltimo, $fechaActual);
        $partidasUltimo = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);
        $preguntasUltimo = $this->model->verCantidadPreguntasPorFecha($fechaUltimo, $fechaActual);
        $preguntasCreadasUsuarioUltimo = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimo, $fechaActual);




        $puntuacionTotal = $this->model->verPuntuacionTotal($fechaUltimo, $fechaActual);
        $totalPartidas = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);

        $totalPreguntasVistas = $puntuacionTotal + $totalPartidas;

        if($puntuacionTotal == 0) {
            $porcentajeRespuestasCorrectas = 0;
        } else {
            $porcentajeRespuestasCorrectas =  ($puntuacionTotal * 100) / $totalPreguntasVistas;
        }
        $totalRespuestasIncorrectas = 100 - $porcentajeRespuestasCorrectas;

        $edadJovenes = $this->model->verCantidadUsuariosJovenesYFecha($fechaUltimo, $fechaActual);
        $edadMedio = $this->model->verCantidadUsuariosMediosYFecha($fechaUltimo, $fechaActual);
        $edadAdultos = $this->model->verCantidadUsuariosJubiladosYFecha($fechaUltimo, $fechaActual);



        //Usuario pais

        $hombre = $this->model->verCantidadUsuariosPorSexoHombre($fechaUltimo, $fechaActual);
        $mujer = $this->model->verCantidadUsuariosPorSexoMujer($fechaUltimo, $fechaActual);
        $otro = $this->model->verCantidadUsuariosPorSexoOtro($fechaUltimo, $fechaActual);

        $paises = $this->model->verCantidadUsuariosPais($fechaUltimo, $fechaActual);




        $data = [
            'graficoPreguntas' => [
                ['Categoría', 'Cantidad'],
                ['Preguntas Creadas', (int)$preguntasUltimo],
                ['Preguntas por Usuario', (int)$preguntasCreadasUsuarioUltimo],
            ],

            'graficoJugadores' => [
                ['Categoría', 'Cantidad'],
                ['Jugadores Totales', (int)$cantidadJugadores],
                ['Usuarios Creados', (int)$usuariosUltimo]
            ],

            'graficoPartidas' => [
                ['Categoría', 'Cantidad'],
                ['Partidas Totales', (int)$cantidadPartidasJugadas],
                ['Partidas jugadas', (int)$partidasUltimo]
            ],

            'graficoEdad' => [
                ['Categoría', 'Cantidad'],
                ['Usuarios jovenes', (int)$edadJovenes],
                ['Usuarios adultos', (int)$edadMedio],
                ['Usuarios ancianos', (int)$edadAdultos]
            ],

            'graficoPorcentaje' => [
                ['Categoría', 'Cantidad'],
                ['Respuestas Incorrectas', $totalRespuestasIncorrectas],
                ['Respuestas Correctas', $porcentajeRespuestasCorrectas]
            ],
            'graficoGenero' => [
                ['Categoría', 'Cantidad'],
                ['Hombres', (int)$hombre],
                ['Mujeres', (int)$mujer],
                ['Otro', (int)$otro],
            ],
            'graficoPais' => [
                ['Categoría', 'Cantidad']
            ],

        ];

        foreach ($paises as $row) {
            $data['graficoPais'][] = [
                (string) $row['pais'],
                (int)$row['total_usuarios_pais']
            ];
        }

        $this->presenter->show("administrador", [
            'data' => json_encode($data), // Convertir a JSON para enviarlo a la vista
        ]);
    }

    public function verGraficosSemana()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimo = date('Y-m-d H:i:s', strtotime('-1 week'));
        $edad = isset($_GET['edad']) ? $_GET['edad'] : null;
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=isset($_GET['username']) ? $_GET['username'] : null;;
        $pais=isset($_GET['pais']) ? $_GET['pais'] : null;;
        $sexo=isset($_GET['sexo']) ? $_GET['sexo'] : null;;

        $cantidadJugadores = $this->model->verCantidadJugadores();
        $cantidadPartidasJugadas = $this->model->verCantidadPartidasJugadas();

        $usuariosUltimo = $this->model->obtenerCantidadUsuarios($fechaUltimo, $fechaActual);
        $partidasUltimo = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);
        $preguntasUltimo = $this->model->verCantidadPreguntasPorFecha($fechaUltimo, $fechaActual);
        $preguntasCreadasUsuarioUltimo = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimo, $fechaActual);




        $puntuacionTotal = $this->model->verPuntuacionTotal($fechaUltimo, $fechaActual);
        $totalPartidas = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);

        $totalPreguntasVistas = $puntuacionTotal + $totalPartidas;

        if($puntuacionTotal == 0) {
            $porcentajeRespuestasCorrectas = 0;
        } else {
            $porcentajeRespuestasCorrectas =  ($puntuacionTotal * 100) / $totalPreguntasVistas;
        }
        $totalRespuestasIncorrectas = 100 - $porcentajeRespuestasCorrectas;

        $edadJovenes = $this->model->verCantidadUsuariosJovenesYFecha($fechaUltimo, $fechaActual);
        $edadMedio = $this->model->verCantidadUsuariosMediosYFecha($fechaUltimo, $fechaActual);
        $edadAdultos = $this->model->verCantidadUsuariosJubiladosYFecha($fechaUltimo, $fechaActual);



        //Usuario pais

        $hombre = $this->model->verCantidadUsuariosPorSexoHombre($fechaUltimo, $fechaActual);
        $mujer = $this->model->verCantidadUsuariosPorSexoMujer($fechaUltimo, $fechaActual);
        $otro = $this->model->verCantidadUsuariosPorSexoOtro($fechaUltimo, $fechaActual);

        $paises = $this->model->verCantidadUsuariosPais($fechaUltimo, $fechaActual);




        $data = [
            'graficoPreguntas' => [
                ['Categoría', 'Cantidad'],
                ['Preguntas Creadas', (int)$preguntasUltimo],
                ['Preguntas por Usuario', (int)$preguntasCreadasUsuarioUltimo],
            ],

            'graficoJugadores' => [
                ['Categoría', 'Cantidad'],
                ['Jugadores Totales', (int)$cantidadJugadores],
                ['Usuarios Creados', (int)$usuariosUltimo]
            ],

            'graficoPartidas' => [
                ['Categoría', 'Cantidad'],
                ['Partidas Totales', (int)$cantidadPartidasJugadas],
                ['Partidas jugadas', (int)$partidasUltimo]
            ],

            'graficoEdad' => [
                ['Categoría', 'Cantidad'],
                ['Usuarios jovenes', (int)$edadJovenes],
                ['Usuarios adultos', (int)$edadMedio],
                ['Usuarios ancianos', (int)$edadAdultos]
            ],

            'graficoPorcentaje' => [
                ['Categoría', 'Cantidad'],
                ['Respuestas Incorrectas', $totalRespuestasIncorrectas],
                ['Respuestas Correctas', $porcentajeRespuestasCorrectas]
            ],
            'graficoGenero' => [
                ['Categoría', 'Cantidad'],
                ['Hombres', (int)$hombre],
                ['Mujeres', (int)$mujer],
                ['Otro', (int)$otro],
            ],
            'graficoPais' => [
                ['Categoría', 'Cantidad']
            ],

        ];

        foreach ($paises as $row) {
            $data['graficoPais'][] = [
                (string) $row['pais'],
                (int)$row['total_usuarios_pais']
            ];
        }

        $this->presenter->show("administrador", [
            'data' => json_encode($data), // Convertir a JSON para enviarlo a la vista
        ]);
    }

    public function verGraficosDia()
    {
        $fechaActual = date('Y-m-d H:i:s');
        $fechaUltimo = date('Y-m-d H:i:s', strtotime('-1 day'));

        $edad = isset($_GET['edad']) ? $_GET['edad'] : null;
        $anioInicio = date('Y', strtotime($fechaActual));
        $anioNacimiento = $anioInicio - $edad;

        $username=isset($_GET['username']) ? $_GET['username'] : null;;
        $pais=isset($_GET['pais']) ? $_GET['pais'] : null;;
        $sexo=isset($_GET['sexo']) ? $_GET['sexo'] : null;;

        $cantidadJugadores = $this->model->verCantidadJugadores();
        $cantidadPartidasJugadas = $this->model->verCantidadPartidasJugadas();

        $usuariosUltimo = $this->model->obtenerCantidadUsuarios($fechaUltimo, $fechaActual);
        $partidasUltimo = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);
        $preguntasUltimo = $this->model->verCantidadPreguntasPorFecha($fechaUltimo, $fechaActual);
        $preguntasCreadasUsuarioUltimo = $this->model->verCantidadDePreguntasCreadasPorFecha($fechaUltimo, $fechaActual);




        $puntuacionTotal = $this->model->verPuntuacionTotal($fechaUltimo, $fechaActual);
        $totalPartidas = $this->model->verCantidadPartidasJugadasPorFecha($fechaUltimo, $fechaActual);

        $totalPreguntasVistas = $puntuacionTotal + $totalPartidas;

        if($puntuacionTotal == 0) {
            $porcentajeRespuestasCorrectas = 0;
        } else {
            $porcentajeRespuestasCorrectas =  ($puntuacionTotal * 100) / $totalPreguntasVistas;
        }
        $totalRespuestasIncorrectas = 100 - $porcentajeRespuestasCorrectas;

        $edadJovenes = $this->model->verCantidadUsuariosJovenesYFecha($fechaUltimo, $fechaActual);
        $edadMedio = $this->model->verCantidadUsuariosMediosYFecha($fechaUltimo, $fechaActual);
        $edadAdultos = $this->model->verCantidadUsuariosJubiladosYFecha($fechaUltimo, $fechaActual);



        //Usuario pais

        $hombre = $this->model->verCantidadUsuariosPorSexoHombre($fechaUltimo, $fechaActual);
        $mujer = $this->model->verCantidadUsuariosPorSexoMujer($fechaUltimo, $fechaActual);
        $otro = $this->model->verCantidadUsuariosPorSexoOtro($fechaUltimo, $fechaActual);

        $paises = $this->model->verCantidadUsuariosPais($fechaUltimo, $fechaActual);




        $data = [
            'graficoPreguntas' => [
                ['Categoría', 'Cantidad'],
                ['Preguntas Creadas', (int)$preguntasUltimo],
                ['Preguntas por Usuario', (int)$preguntasCreadasUsuarioUltimo],
            ],

            'graficoJugadores' => [
                ['Categoría', 'Cantidad'],
                ['Jugadores Totales', (int)$cantidadJugadores],
                ['Usuarios Creados', (int)$usuariosUltimo]
            ],

            'graficoPartidas' => [
                ['Categoría', 'Cantidad'],
                ['Partidas Totales', (int)$cantidadPartidasJugadas],
                ['Partidas jugadas', (int)$partidasUltimo]
            ],

            'graficoEdad' => [
                ['Categoría', 'Cantidad'],
                ['Usuarios jovenes', (int)$edadJovenes],
                ['Usuarios adultos', (int)$edadMedio],
                ['Usuarios ancianos', (int)$edadAdultos]
            ],

            'graficoPorcentaje' => [
                ['Categoría', 'Cantidad'],
                ['Respuestas Incorrectas', $totalRespuestasIncorrectas],
                ['Respuestas Correctas', $porcentajeRespuestasCorrectas]
            ],
            'graficoGenero' => [
                ['Categoría', 'Cantidad'],
                ['Hombres', (int)$hombre],
                ['Mujeres', (int)$mujer],
                ['Otro', (int)$otro],
            ],
            'graficoPais' => [
                ['Categoría', 'Cantidad']
            ],

        ];

        foreach ($paises as $row) {
            $data['graficoPais'][] = [
                (string) $row['pais'],
                (int)$row['total_usuarios_pais']
            ];
        }

        $this->presenter->show("administrador", [
            'data' => json_encode($data), // Convertir a JSON para enviarlo a la vista
        ]);
    }

    public function pdf()
    {
       $preguntas = $_POST['variablePreguntas'];
           $jugadores = $_POST['variableJugadores'];
           $partidas = $_POST['variablePartidas'];
               $edad = $_POST['variableEdad'];
                   $porcentaje = $_POST['variablePorcentaje'];
                       $genero = $_POST['variableGenero'];
                           $pais = $_POST['variablePais'];

        $pdf = new FPDF();
        $pdf->AddPage('L', 'A3'); // Cambia a orientación horizontal A3
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Graficos');


        $pdf->image($preguntas, 20, 20, 150, 100, 'png'); 
        $pdf->image($jugadores, 150, 20, 150, 100,'png');
        $pdf->image($partidas, 280, 20, 150, 100, 'png');


        $pdf->image($edad, 20, 100, 150, 100, 'png');
        $pdf->image($porcentaje, 150, 100, 150, 100, 'png');
        $pdf->image($genero, 280, 100, 150, 100, 'png');


        $pdf->image($pais, 20, 200, 150, 100, 'png');

        $pdf->Output();
    }

}
