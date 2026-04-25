<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Iniciar sesión para CSRF
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Router;
$router = new Router();
$action = $_GET['action'] ?? 'dashboard';
$router->handleRequest($action);