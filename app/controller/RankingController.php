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
        if ($_SESSION['tipo_cuenta'] == 2) {
            header('Location: /Monquiz/app/administrador/verGraficosAno');
            exit();
        }
        $ranking = $this->model->getRanking();


        $ranking_mundial = [];
        if (!empty($ranking)) {

            for ($i = 0; $i < min(3, count($ranking)); $i++) {
                $ranking_mundial[] = [
                    'usuario' => $ranking[$i]['username'],
                    'puntuacion' => $ranking[$i]['puntuacion']
                ];
            }
        }

        $data = [
            'ranking_mundial' => $ranking_mundial,
            'user' => $_SESSION['username'],
            'imagenHeader' => $_SESSION['imagen']
        ];

        $this->presenter->show("ranking", $data);
    }




}