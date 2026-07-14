<?php

namespace App;

use App\Config\Database;

class Router
{
    private $db;

    // Tabla de enrutamiento
    private $routes = [
        'login'            => ['controller' => 'App\Controllers\AuthController', 'method' => 'loginView'],
        'doLogin'          => ['controller' => 'App\Controllers\AuthController', 'method' => 'login', 'params' => ['$_POST']],
        'logout'           => ['controller' => 'App\Controllers\AuthController', 'method' => 'logout'],

        'dashboard' => ['controller' => 'App\Controllers\DashboardController', 'method' => 'index'],

        // Incomes
        'incomes'          => ['controller' => 'App\Controllers\IncomesController', 'method' => 'index'],
        'createIncome'     => ['controller' => 'App\Controllers\IncomesController', 'method' => 'create', 'params' => ['$_POST']],
        'updateIncome'     => ['controller' => 'App\Controllers\IncomesController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteIncome'     => ['controller' => 'App\Controllers\IncomesController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'exportIncomesXls' => ['controller' => 'App\Controllers\IncomesController', 'method' => 'exportXls'],

        // Expenses
        'expenses'          => ['controller' => 'App\Controllers\ExpensesController', 'method' => 'index'],
        'createExpense'     => ['controller' => 'App\Controllers\ExpensesController', 'method' => 'create', 'params' => ['$_POST']],
        'updateExpense'     => ['controller' => 'App\Controllers\ExpensesController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteExpense'     => ['controller' => 'App\Controllers\ExpensesController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'exportExpensesXls' => ['controller' => 'App\Controllers\ExpensesController', 'method' => 'exportXls'],

        // Balance
        'balance'          => ['controller' => 'App\Controllers\BalanceController', 'method' => 'index', 'params' => ['$_POST']],
        'exportBalanceXls' => ['controller' => 'App\Controllers\BalanceController', 'method' => 'exportXls', 'params' => ['$_POST']],

        // Reports
        'reports'          => ['controller' => 'App\Controllers\ReportsController', 'method' => 'index', 'params' => ['$_POST']],
        'exportReportsXls' => ['controller' => 'App\Controllers\ReportsController', 'method' => 'exportXls', 'params' => ['$_POST']],

        // Loans
        'loans'          => ['controller' => 'App\Controllers\LoansController', 'method' => 'index'],
        'createLoan'     => ['controller' => 'App\Controllers\LoansController', 'method' => 'create', 'params' => ['$_POST']],
        'updateLoan'     => ['controller' => 'App\Controllers\LoansController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteLoan'     => ['controller' => 'App\Controllers\LoansController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'exportLoansXls' => ['controller' => 'App\Controllers\LoansController', 'method' => 'exportXls'],
        'getLoanPayments'=> ['controller' => 'App\Controllers\LoansController', 'method' => 'getPayments', 'params' => ['$_GET[id]']],

        // Categories
        'categories'        => ['controller' => 'App\Controllers\CategoriesController', 'method' => 'index'],
        'createCategory'    => ['controller' => 'App\Controllers\CategoriesController', 'method' => 'create', 'params' => ['$_POST']],
        'updateCategory'    => ['controller' => 'App\Controllers\CategoriesController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteCategory'    => ['controller' => 'App\Controllers\CategoriesController', 'method' => 'delete', 'params' => ['$_POST[id]']],

        // Inventory
        'inventory'          => ['controller' => 'App\Controllers\InventoryController', 'method' => 'index'],
        'createProduct'      => ['controller' => 'App\Controllers\InventoryController', 'method' => 'create', 'params' => ['$_POST']],
        'updateProduct'      => ['controller' => 'App\Controllers\InventoryController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteProduct'      => ['controller' => 'App\Controllers\InventoryController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'adjustStock'        => ['controller' => 'App\Controllers\InventoryController', 'method' => 'adjustStock', 'params' => ['$_POST']],
        'getProductMovements'=> ['controller' => 'App\Controllers\InventoryController', 'method' => 'getMovements', 'params' => ['$_GET[id]']],
        'exportInventoryXls' => ['controller' => 'App\Controllers\InventoryController', 'method' => 'exportXls'],

        // Orders
        'orders'             => ['controller' => 'App\Controllers\OrdersController', 'method' => 'index'],
        'createOrder'        => ['controller' => 'App\Controllers\OrdersController', 'method' => 'create', 'params' => ['$_POST']],
        'updateOrder'        => ['controller' => 'App\Controllers\OrdersController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteOrder'        => ['controller' => 'App\Controllers\OrdersController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'updateOrderStatus'  => ['controller' => 'App\Controllers\OrdersController', 'method' => 'updateStatus', 'params' => ['$_POST']],
        'getOrderItems'      => ['controller' => 'App\Controllers\OrdersController', 'method' => 'getItems', 'params' => ['$_GET[id]']],
        'exportOrdersXls'    => ['controller' => 'App\Controllers\OrdersController', 'method' => 'exportXls'],
    ];

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function handleRequest($action)
    {
        // Rutas que no requieren login
        $publicActions = ['login', 'doLogin'];

        // Si no está logueado y no es una ruta pública, redirigir a login
        if (!isset($_SESSION['user_id']) && !in_array($action, $publicActions)) {
            header("Location: ?action=login");
            exit;
        }

        // Validación CSRF para todas las peticiones POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $this->handleError('Error de seguridad: Token CSRF inválido.');
            }
        }

        // Si la acción no existe en las rutas, se va por defecto al dashboard
        if (!array_key_exists($action, $this->routes)) {
            $action = 'dashboard';
        }

        $route = $this->routes[$action];
        $controllerName = $route['controller'];
        $methodName = $route['method'];

        // Instanciar solo el controlador necesario (Autoloading lo encuentra)
        $controller = new $controllerName($this->db);

        // Resolver los parámetros si la ruta los define
        $args = [];
        if (isset($route['params'])) {
            foreach ($route['params'] as $param) {
                if ($param === '$_POST') {
                    $args[] = $_POST;
                } elseif ($param === '$_POST[id]') {
                    $args[] = $_POST['id'] ?? null;
                } elseif ($param === '$_GET[id]') {
                    $args[] = $_GET['id'] ?? null;
                }
            }
        }

        // Llamar al método correspondiente pasando los argumentos
        try {
            call_user_func_array([$controller, $methodName], $args);
        } catch (\Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    private function handleError($message)
    {
        // Si es AJAX, responder con JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $message]);
        } else {
            // Si es petición normal, mostrar error simple o redirigir
            die($message);
        }
        exit;
    }
}
