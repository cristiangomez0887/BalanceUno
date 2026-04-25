<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Router;

$router = new Router();
$action = $_GET['action'] ?? 'dashboard';
$router->handleRequest($action);