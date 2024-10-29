<?php

class RankingController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function mostrarRanking(){
        $data = [
            'ranking_mundial_titulo' => 'Ranking Mundial',
            'ranking_mundial' => [
                ['usuario' => 'Usuario1'],
                ['usuario' => 'Usuario2'],
                ['usuario' => 'Usuario3'],
                // Añadir más datos...
            ],
            'historial_titulo' => 'Historial',
            'historial' => [
                ['fecha' => '2024-10-01'],
                ['fecha' => '2024-09-30'],
                ['fecha' => '2024-09-30']
                // Añadir más datos...
            ],
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        $this->presenter->show("ranking", $data);


    }




}