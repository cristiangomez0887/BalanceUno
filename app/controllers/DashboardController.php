<?php

namespace App\Controllers;

use App\Models\Dashboard;

class DashboardController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new Dashboard($db);
    }

    public function index()
    {

        $data = $this->model->getData();
        include __DIR__ . '/../../views/dashboard.php';
    }
}
