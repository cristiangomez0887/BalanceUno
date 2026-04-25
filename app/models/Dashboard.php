<?php
class Dashboard
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getData()
    {
        // Ingresos Totales
        $stmt = $this->db->prepare("SELECT SUM(amount) AS total FROM incomes WHERE deleted_at IS NULL");
        $stmt->execute();
        $incomes = $stmt->fetchColumn() ?? 0;


        // Gastos Totales
        $stmt = $this->db->prepare("SELECT SUM(amount) AS total FROM expenses WHERE deleted_at IS NULL");
        $stmt->execute();
        $expenses = $stmt->fetchColumn() ?? 0;

        // Totales

        $balance = $incomes - $expenses;


        return [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'balance' => $balance,
        ];
    }
}
