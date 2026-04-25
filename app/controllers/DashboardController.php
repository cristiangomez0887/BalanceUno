<?php
require_once __DIR__ . '/../models/Dashboard.php';

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
