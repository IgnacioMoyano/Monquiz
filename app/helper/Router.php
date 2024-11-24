<?php

class Router
{
    private $defaultController;
    private $defaultMethod;
    private $configuration;
    private $allowedRoutes = [
        0 => [
            '/Monquiz/app/usuario/login',
            '/Monquiz/app/lobby/mostrarLobby',
            '/Monquiz/app/perfil/mostrarPerfil',
            '/Monquiz/app/ranking/mostrarRanking',
            '/Monquiz/app/partida/crearPartida/',
            '/Monquiz/app/lobby/mostrarSugerencia/',
            '/Monquiz/app/partida/mostrarPregunta',
            '/Monquiz/app/partida/resultado',
            '/Monquiz/app/partida/jugar',
            '/Monquiz/app/partida/reportar',
            '/Monquiz/app/partida/enviarReporte',
            '/Monquiz/app/usuario/logout',

        ],
        1 => [ // Rutas permitidas para tipo_cuenta = 1 (por ejemplo, editores)
            '/Monquiz/app/editor/home',
            '/Monquiz/app/editor/verPreguntas',
            '/Monquiz/app/editor/verPreguntasPendientes',
            '/Monquiz/app/editor/verPreguntasReportadas',
            '/Monquiz/app/editor/verCrearPregunta',
            '/Monquiz/app/editor/editarPregunta',
            '/MONQUIZ/app/editor/modificarPregunta',
            '/Monquiz/app/editor/enviarPregunta'

        ],
        2 => [ // Rutas permitidas para tipo_cuenta = 2 (por ejemplo, administradores)
            '/Monquiz/app/administrador/verGraficosAno',
            '/Monquiz/app/administrador/verGraficosAno'

        ]
    ];

    public function __construct($configuration, $defaultController, $defaultMethod)
    {
        $this->defaultController = $defaultController;
        $this->defaultMethod = $defaultMethod;
        $this->configuration = $configuration;
    }

    public function route($controllerName, $methodName)
    {
        $this->validateAccess($controllerName, $methodName);

        $controller = $this->getControllerFrom($controllerName);
        $this->executeMethodFromController($controller, $methodName);
    }

    private function validateAccess($controllerName, $methodName)
    {
        $publicRoutes = [
        '/Monquiz/app/usuario/login', // Página de inicio de sesión
        '/Monquiz/app/usuario/register',
        '/Monquiz/app/logout',
        '/Monquiz/app/usuario/auth',
            // Página de registro (si existe)
        ];

        if (!isset($_SESSION['username'])) {
            header('Location: /Monquiz/app/usuario/login');
            exit();
        }

        $currentPath = rtrim($this->getCurrentPath(), '/');

        // Permitir acceso a rutas públicas sin validación
        if (in_array($currentPath, $publicRoutes)) {
            return; // Permitir continuar sin redirección
        }

        // Verificar si el usuario está autenticado


        // Verificar si el usuario está validado


        // Validar acceso según el tipo de cuenta
        $tipoCuenta = $_SESSION['tipo_cuenta'];

        if (!isset($this->allowedRoutes[$tipoCuenta]) ||
            !$this->isPathAllowed($currentPath, $this->allowedRoutes[$tipoCuenta])) {
            // Redirigir al usuario a su ruta principal
            header('Location: ' . $this->allowedRoutes[$tipoCuenta][0]);
            exit();
        }

    }


    private function getControllerFrom($module)
    {
        $controllerName = 'get' . ucfirst($module) . 'Controller';
        $validController = method_exists($this->configuration, $controllerName) ? $controllerName : $this->defaultController;
        return call_user_func(array($this->configuration, $validController));
    }

    private function executeMethodFromController($controller, $method)
    {
        $validMethod = method_exists($controller, $method) ? $method : $this->defaultMethod;
        call_user_func(array($controller, $validMethod));
    }

    private function getCurrentPath()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function isPathAllowed($currentPath, $allowedRoutes)
    {
        // Obtener la ruta base sin parámetros
        $basePath = parse_url($currentPath, PHP_URL_PATH);

        foreach ($allowedRoutes as $route) {
            // Compara la ruta base con las rutas permitidas
            if (strpos($basePath, rtrim($route, '/')) === 0) {
                return true;
            }
        }
        return false;
    }
}

