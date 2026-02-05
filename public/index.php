<?php
require_once __DIR__ . '/../app/Router.php';

$router = new Router();
$action = $_GET['action'] ?? 'dashboard';
$router->handleRequest($action);