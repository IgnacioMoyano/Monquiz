<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once("configuration/Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();

$page = $_GET['page'] ?? 'login'; // Página predeterminada: "perfil"
$action = isset($_GET['action']) ? $action = $_GET['action'] : $action = 'index';
$router->route($_GET['page'], $action);