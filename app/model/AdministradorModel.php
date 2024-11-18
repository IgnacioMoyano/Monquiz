<?php

class AdministradorModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function verCantidadJugadores()
    {
        $sql = "SELECT COUNT(*) AS cantidad_jugadores FROM usuario";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_jugadores'];
    }

    function obtenerCantidadUsuarios($fechaFin, $fechaInicio)
    {
        $sql = "SELECT COUNT(*) AS total_usuarios 
FROM usuario 
WHERE fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'   ";
        $result = $this->database->query($sql);
        return $result[0]['total_usuarios'];
    }


    public function verCantidadPartidasJugadas()
    {
        $sql = "SELECT COUNT(*) AS cantidad_partidas FROM partida";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_partidas'];
    }

    public function verCantidadPartidasJugadasPorFecha($fechaFin, $fechaInicio)
    {
        $sql = "SELECT COUNT(*) AS cantidad_partidas FROM partida WHERE fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_partidas'];
    }


    public function verCantidadPreguntas()
    {
        $sql = "SELECT COUNT(*) AS cantidad_preguntas FROM pregunta";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_preguntas'];
    }

    public function verCantidadPreguntasPorFecha($fechaFin, $fechaInicio)
    {
        $sql = "SELECT COUNT(*) AS cantidad_preguntas FROM pregunta WHERE fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_preguntas'];
    }


    public function verCantidadDePreguntasCreadas()
    {
        $sql = "SELECT COUNT(*) AS cantidad_preguntasUsuario FROM pregunta WHERE creada_usuarios=1";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_preguntasUsuario'];
    }

    public function verCantidadDePreguntasCreadasPorFecha($fechaFin, $fechaInicio)
    {
        $sql = "SELECT COUNT(*) AS cantidad_preguntasUsuario FROM pregunta WHERE creada_usuarios=1 AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_preguntasUsuario'];
    }


    public function porcentajeRespuestasCorrectas($username)
    {
        $sql = "SELECT cantidad_preg_vistas, cantidad_preg_correctas FROM usuario WHERE username='$username'  ";
        $result = $this->database->query($sql);

        return $result[0]['cantidad_usuariosNuevos'];
    }

    public function porcentajeRespuestasCorrectasPorFecha($fechaFin, $fechaInicio, $username)
    {
        $sql = "SELECT cantidad_preg_vistas, cantidad_preg_correctas  FROM usuario WHERE username='$username' AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'";
        $result = $this->database->query($sql);
        if (!empty($result)) {
            $row = $result[0]; // Obtén la primera fila del arreglo asociativo
            $vistas = $row['cantidad_preg_vistas'];
            $correctas = $row['cantidad_preg_correctas'];

            if ($vistas > 0) {
                $porcentaje = ($correctas / $vistas) * 100;
            } else {
                $porcentaje = 0; // Evita división por cero
            }

            return $porcentaje;
        }

        // Si no hay resultados, retorna 0
        return 0;
    }





    public function verCantidadUsuariosPorPais($pais)
    {
        $sql = "SELECT COUNT(*) AS total_usuarios_porPais
FROM usuario 
WHERE pais='$pais' ";
        $result = $this->database->query($sql);
        return $result[0]['total_usuarios_porPais'];
    }

    public function verCantidadUsuariosPorPaisYFecha($fechaFin, $fechaInicio, $pais)
    {
        $sql = "SELECT COUNT(*) AS total_usuarios_porPais 
FROM usuario 
WHERE pais='$pais' AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'";
        $result = $this->database->query($sql);
        return $result[0]['total_usuarios_porPais'];
    }


    public function verCantidadUsuariosPorSexo($sexo)
    {
        $sql = "SELECT COUNT(*) AS total_usuarios_porSexo 
FROM usuario 
WHERE genero='$sexo'";
        $result = $this->database->query($sql);
        return $result[0]['total_usuarios_porSexo'];
    }
    public function verCantidadUsuariosPorSexoYFecha($fechaFin, $fechaInicio, $sexo)
    {
        $sql = "SELECT COUNT(*) AS total_usuarios_porSexo 
FROM usuario 
WHERE genero='$sexo' AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'";
        $result = $this->database->query($sql);
        return $result[0]['total_usuarios_porSexo'];
    }


    public function verCantidadUsuariosPorEdad($edad)
    {
        $sql = "SELECT COUNT(*) AS total_usuarios_porEdad 
FROM usuario 
WHERE fecha_nac='$edad'";
        $result = $this->database->query($sql);
        return $result[0]['total_usuarios_porEdad'];
    }

    public function verCantidadUsuariosPorEdadYFecha($fechaFin, $fechaInicio, $edad)
    {

        $sql = "SELECT COUNT(*) AS total_usuarios_porEdad 
FROM usuario 
WHERE fecha_nac='$edad' AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaInicio'";
        $result = $this->database->query($sql);
        return $result[0]['total_usuarios_porEdad'];
    }


}



/*Por otro lado debe existir el usuario administrador, capaz de ver la cantidad de jugadores que tiene
la aplicación, cantidad de partidas jugadas, cantidad de preguntas en el juego, cantidad de
preguntas creadas, cantidad de usuarios nuevos, porcentaje de preguntas respondidas
correctamente por usuario, cantidad de usuarios por pais, cantidad de usuarios por sexo, cantidad
de usuarios por grupo de edad (menores, jubilados, medio). Todos estos gráficos deben poder
filtrarse por día, semana, mes o año. Estos reportes tienen que poder imprimirse (al menos las
tablas de datos)*/