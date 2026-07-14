<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new User($db);
    }

    public function loginView()
    {
        // Si ya está logueado, ir al dashboard
        if (isset($_SESSION['user_id'])) {
            header("Location: ?action=dashboard");
            exit;
        }
        include __DIR__ . '/../../views/login.php';
    }

    public function login($data)
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = "Usuario y contraseña son requeridos.";
            include __DIR__ . '/../../views/login.php';
            return;
        }

        $user = $this->model->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_name'] = $user['name'] ?? $user['username'];
            $_SESSION['company_id'] = $user['company_id'];
            $_SESSION['company_name'] = $user['company_name'];
            $_SESSION['company_tax_rate'] = $user['company_tax_rate'];
            header("Location: ?action=dashboard");
            exit;
        } else {
            $error = "Credenciales incorrectas.";
            include __DIR__ . '/../../views/login.php';
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: ?action=login");
        exit;
    }
}
