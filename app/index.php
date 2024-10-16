<?php
session_start();
include_once("configuration/Configuration.php");
$configuration = new Configuration();
$router = $configuration->getRouter();

$action = isset($_GET['action']) ? $action = $_GET['action'] : $action = 'index';
$router->route($_GET['page'], $action);