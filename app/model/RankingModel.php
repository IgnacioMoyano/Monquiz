<?php

class RankingModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getRanking() {
        $sql = "
        SELECT p.usuario_FK, p.puntuacion, u.username, u.imagen
        FROM partida p
        JOIN usuario u ON p.usuario_FK = u.id
        ORDER BY p.puntuacion DESC
        LIMIT 3
    ";
        $result = $this->database->query($sql);
        return $result;
    }

}