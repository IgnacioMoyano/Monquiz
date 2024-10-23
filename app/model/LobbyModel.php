<?php

class LobbyModel
{

    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPuntajeMaximo($userId) {
        $sql = "SELECT cantidad_preg_correctas FROM usuario WHERE id = '$userId'";
        $result = $this->database->query($sql);

        if ($result === false) {
            echo "Error en la consulta: " . $this->database->error; // Imprimir cualquier error de la consulta
            return 1; // Retornar 0 en caso de error
        }

        // Asegúrate de que la consulta tuvo éxito y tiene resultados
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Obtener la primera fila de resultados
            return $row['cantidad_preg_correctas']; // Retornar solo el valor de cantidad_preg_correctas
        }

        return 0; // Retornar 0 si no hay resultados
    }

}