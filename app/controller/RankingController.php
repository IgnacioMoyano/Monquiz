<?php

class RankingController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function mostrarRanking() {

        $ranking = $this->model->getRanking();


        $data = [
            'ranking_mundial_titulo' => 'Ranking Mundial',
            'ranking_mundial' => [
                ['usuario' => $ranking[0]['username'], 'imagen' => $ranking[0]['imagen'], 'puntuacion' => $ranking[0]['puntuacion']],
                ['usuario' => $ranking[1]['username'], 'imagen' => $ranking[1]['imagen'], 'puntuacion' => $ranking[1]['puntuacion']],
                ['usuario' => $ranking[2]['username'], 'imagen' => $ranking[2]['imagen'], 'puntuacion' => $ranking[2]['puntuacion']]
            ],
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        // Muestra la vista con los datos
        $this->presenter->show("ranking", $data);
    }




}