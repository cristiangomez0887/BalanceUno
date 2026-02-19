<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/IncomesController.php';
require_once __DIR__ . '/controllers/ExpensesController.php';
require_once __DIR__ . '/controllers/BalanceController.php';
require_once __DIR__ . '/controllers/ReportsController.php';


class Router
{
    private $db;
    private $incomesController;
    private $expensesController;
    private $balanceController;
    private $reportsController;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->incomesController = new IncomesController($this->db);
        $this->expensesController = new ExpensesController($this->db);
        $this->balanceController = new BalanceController($this->db);
        $this->reportsController = new ReportsController($this->db);
    }

    public function handleRequest($action)
    {
        switch ($action) {
            case 'incomes':
                $this->incomesController->index();
                break;
            case 'createIncome':
                $this->incomesController->create($_POST);
                break;
            case 'updateIncome':
                exit;
                $this->incomesController->update($_POST['id'], $_POST);
                break;
            case 'deleteIncome':
                $this->incomesController->delete($_POST['id']);
                break;
            case 'exportIncomesXls':
                $this->incomesController->exportXls();
                break;

            case 'expenses':
                $this->expensesController->index();
                break;
            case 'createExpense':
                $this->expensesController->create($_POST);
                break;
            case 'updateExpense':
                $this->expensesController->update($_POST['id'], $_POST);
                break;
            case 'deleteExpense':
                $this->expensesController->delete($_POST['id']);
                break;
            case 'exportExpensesXls':
                $this->expensesController->exportXls();
                break;
            case 'balance':
                $this->balanceController->index($_POST);
                break;
            case 'exportBalanceXls':
                $this->balanceController->exportXls($_POST);
                break;
            case 'reports':
                $this->reportsController->index($_POST);
                break;
            case 'exportReportsXls':
                $this->reportsController->exportXls($_POST);
                break;
            default:
                include __DIR__ . '/../views/dashboard.php';
                break;
        }
    }
}
