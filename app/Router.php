<?php
require_once __DIR__ . '/config/database.php';

class Router
{
    private $db;

    // Tabla de enrutamiento
    private $routes = [
        'dashboard' => ['controller' => 'DashboardController', 'method' => 'index'],

        // Incomes
        'incomes'          => ['controller' => 'IncomesController', 'method' => 'index'],
        'createIncome'     => ['controller' => 'IncomesController', 'method' => 'create', 'params' => ['$_POST']],
        'updateIncome'     => ['controller' => 'IncomesController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteIncome'     => ['controller' => 'IncomesController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'exportIncomesXls' => ['controller' => 'IncomesController', 'method' => 'exportXls'],

        // Expenses
        'expenses'          => ['controller' => 'ExpensesController', 'method' => 'index'],
        'createExpense'     => ['controller' => 'ExpensesController', 'method' => 'create', 'params' => ['$_POST']],
        'updateExpense'     => ['controller' => 'ExpensesController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteExpense'     => ['controller' => 'ExpensesController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'exportExpensesXls' => ['controller' => 'ExpensesController', 'method' => 'exportXls'],

        // Balance
        'balance'          => ['controller' => 'BalanceController', 'method' => 'index', 'params' => ['$_POST']],
        'exportBalanceXls' => ['controller' => 'BalanceController', 'method' => 'exportXls', 'params' => ['$_POST']],

        // Reports
        'reports'          => ['controller' => 'ReportsController', 'method' => 'index', 'params' => ['$_POST']],
        'exportReportsXls' => ['controller' => 'ReportsController', 'method' => 'exportXls', 'params' => ['$_POST']],

        // Loans
        'loans'          => ['controller' => 'LoansController', 'method' => 'index'],
        'createLoan'     => ['controller' => 'LoansController', 'method' => 'create', 'params' => ['$_POST']],
        'updateLoan'     => ['controller' => 'LoansController', 'method' => 'update', 'params' => ['$_POST[id]', '$_POST']],
        'deleteLoan'     => ['controller' => 'LoansController', 'method' => 'delete', 'params' => ['$_POST[id]']],
        'exportLoansXls' => ['controller' => 'LoansController', 'method' => 'exportXls'],
    ];

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function handleRequest($action)
    {
        // Si la acción no existe en las rutas, se va por defecto al dashboard
        if (!array_key_exists($action, $this->routes)) {
            $action = 'dashboard';
        }

        $route = $this->routes[$action];
        $controllerName = $route['controller'];
        $methodName = $route['method'];

        // Cargar el archivo del controlador de forma dinámica
        require_once __DIR__ . '/controllers/' . $controllerName . '.php';

        // Instanciar solo el controlador necesario
        $controller = new $controllerName($this->db);

        // Resolver los parámetros si la ruta los define
        $args = [];
        if (isset($route['params'])) {
            foreach ($route['params'] as $param) {
                if ($param === '$_POST') {
                    $args[] = $_POST;
                } elseif ($param === '$_POST[id]') {
                    $args[] = $_POST['id'] ?? null;
                }
            }
        }

        // Llamar al método correspondiente pasando los argumentos
        call_user_func_array([$controller, $methodName], $args);
    }
}
