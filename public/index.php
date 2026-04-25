<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;

$router = new Router();
$action = $_GET['action'] ?? 'dashboard';
$router->handleRequest($action);