<?php
class PerfilController{
    private $model;
    private $presenter;




    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }
    public function mostrarPerfil() {
        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }
        if ($_SESSION['validado'] != 1) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $imagenUserLogueado = $_SESSION['imagen'];
        $userLogueado = $_SESSION['username'];
        $datosUsuarioLogueado = $this->model->getPerfil($userLogueado);

        if (isset($_GET['username'])) {
            $usernamePerfil = $_GET['username'];
        } else {
            $usernamePerfil = $userLogueado;
        }

        $datosPerfil = $this->model->getPerfil($usernamePerfil);

        if (empty($datosPerfil)) {
            echo "No se encontraron datos para el usuario.";
            exit();
        }

        $perfil = $datosPerfil[0];
        $url = "http://localhost/Monquiz/app/perfil/mostrarPerfil/$usernamePerfil";

        $puntaje = $this->model->getPuntaje($usernamePerfil);

        ob_start();
        QRcode::png($url, null, QR_ECLEVEL_L, 4);
        $qrImage = ob_get_contents();
        ob_end_clean();
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrImage);

        $esUsuarioLogeado = ($usernamePerfil === $userLogueado);

        $idUser = $_SESSION['id'];

        $puntaje = $this->model->getPuntajeMaximo($idUser);

        $data = [
            'user' => $userLogueado,
            'perfil' => [
                'username' => $perfil['username'] ?? 'Usuario no disponible',
                'imagen' => $perfil['imagen'] ?? '/Monquiz/app/public/images/fotosPerfil/Designer.jpeg',
                'correo' => $perfil['correo'] ?? 'Correo no disponible',
                'fecha_nac' => $perfil['fecha_nac'] ?? 'Fecha no disponible',
                'genero' => $perfil['genero'] ?? 'No especificado',
                'ciudad' => $perfil['ciudad'] ?? 'Dirección no disponible',
                'puntaje' => $puntaje ?? 'Puntaje no disponible',
            ],
            'esUsuarioLogeado' => $esUsuarioLogeado,
            'imagenHeader' => $imagenUserLogueado,
            'qrCodeBase64' => $qrCodeBase64,
            'puntaje' => $puntaje
        ];

        $this->presenter->show('perfil', $data);
    }
}